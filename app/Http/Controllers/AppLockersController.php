<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Locker;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\LocksWReadyCard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AppLockersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Get lockers for the authenticated user with their items
        $lockers = Locker::with(['items' => function($query) {
                $query->orderBy('number_locker');
            }])
            ->where('user_id', auth()->id())
            ->get();
    
        return view('app.lockers.index', compact('lockers'));
    }

    public function createRequest()
    {
        $lockers = LocksWReadyCard::where('type','lock')->where('is_active', true)->get();
        $user = Auth::user();
        return view('app.lockers.new_request', compact('lockers', 'user'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'locker_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $locker = LocksWReadyCard::findOrFail($request->locker_id);
        
        Session::put('pending_locker', [
            'locker_id' => $locker->id,
            'quantity' => $request->quantity,
            'total_price' => $locker->price * $request->quantity,
        ]);

        return redirect()->route('min-alqalb.lockers.summary');
    }

    public function showSummary()
    {
        $pendingLocker = Session::get('pending_locker');
        
        if (!$pendingLocker || !isset($pendingLocker['locker_id'])) {
            return redirect()->route('min-alqalb.lockers.create')
                ->with('error', 'لم يتم اختيار قفل. يرجى المحاولة مرة أخرى.');
        }

        $locker = LocksWReadyCard::findOrFail($pendingLocker['locker_id']);
        $quantity = $pendingLocker['quantity'];
        $totalPrice = $pendingLocker['total_price'];

        return view('app.lockers.finish_new_request', compact('locker', 'quantity', 'totalPrice'));
    }

    public function purchase(Request $request)
    {
        $pendingLocker = Session::get('pending_locker');
        
        if (!$pendingLocker || !isset($pendingLocker['locker_id'])) {
            return redirect()->route('min-alqalb.lockers.create')
                ->with('error', 'لم يتم اختيار قفل. يرجى المحاولة مرة أخرى.');
        }

        $locker = LocksWReadyCard::where('is_active', true)->findOrFail($pendingLocker['locker_id']);
        $quantity = $pendingLocker['quantity'];
        $totalPrice = $pendingLocker['total_price'];
        
        DB::beginTransaction();
        
        try {
            if (!Auth::check()) {
                throw new Exception('المستخدم غير مصادق عليه.');
            }
            
            $payment = new Payment();
            $payment->user_id = Auth::id();
            $payment->amount = $totalPrice;
            $payment->currency = 'AED';
            $payment->type = 'lock';
            $payment->status = 'pending';
            $payment->save();
            
            Session::put('locker_payment_' . $payment->id, [
                'locker_id' => $locker->id,
                'quantity' => $quantity,
            ]);
            
            $amountInFils = (int)($totalPrice * 100);
            
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . config('ziina.api_key'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('ziina.api_url', 'https://api-v2.ziina.com/api') . '/payment_intent', [
                'amount' => $amountInFils,
                'currency_code' => 'AED',
                'success_url' => route('min-alqalb.lockers.payment.success', ['order_id' => 'lck_' . $payment->id]),
                'cancel_url' => route('min-alqalb.lockers.payment.cancel', ['order_id' => 'lck_' . $payment->id]),
                'description' => 'Locker Purchase: ' . ($locker->name_ar ?? 'Locker ID: ' . $locker->id),
                'test' => config('ziina.test_mode', true),
                'metadata' => [
                    'locker_id' => (string)$locker->id,
                    'user_id' => (string)Auth::id(),
                    'payment_type' => 'lock',
                    'quantity' => $quantity,
                ],
            ]);
            
            // Log::info('Ziina API response in locker purchase', [
            //     'status' => $response->status(),
            //     'body' => $response->json(),
            // ]);
            
            if ($response->successful()) {
                $paymentIntent = $response->json();
                
                if (!isset($paymentIntent['id']) || !isset($paymentIntent['redirect_url'])) {
                    // Log::error('Invalid payment intent response', ['response' => $paymentIntent]);
                    throw new Exception('فشل في استرجاع معرف نية الدفع أو رابط الإعادة التوجيه');
                }
                
                $payment->payment_intent_id = $paymentIntent['id'];
                $payment->redirect_url = $paymentIntent['redirect_url'];
                $payment->save();
                
                DB::commit();
                
                return redirect($paymentIntent['redirect_url']);
            } else {
                $responseData = $response->json();
                $errorMessage = isset($responseData['message']) 
                    ? (is_array($responseData['message']) ? implode(', ', $responseData['message']) : $responseData['message'])
                    : ($responseData['error'] ?? 'خطأ غير معروف من بوابة الدفع');
                
                // Log::error('Ziina API error', ['error' => $errorMessage]);
                throw new Exception('خطأ بوابة الدفع: ' . $errorMessage);
            }
        } catch (Exception $e) {
            DB::rollBack();
            // Log::error('Locker payment processing exception', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);
            return redirect()->route('min-alqalb.lockers.create')
                ->with('error', 'فشل معالجة الدفع: ' . $e->getMessage());
        }
    }

    public function handleSuccess(Request $request)
    {
        $paymentId = explode('_', $request->query('order_id', ''))[1] ?? null;
        
        if (!$paymentId) {
            // Log::error('Invalid order_id in locker handleSuccess', ['order_id' => $request->query('order_id')]);
            return redirect()->route('min-alqalb.lockers.index')
                ->with('error', 'معلومات الدفع غير صالحة.');
        }
        
        try {
            $payment = Payment::where('id', $paymentId)
                ->where('user_id', Auth::id())
                ->where('type', 'lock')
                ->first();
            
            if (!$payment) {
                // Log::error('Locker payment record not found or user mismatch', [
                //     'payment_id' => $paymentId,
                //     'user_id' => Auth::id(),
                // ]);
                return redirect()->route('min-alqalb.lockers.index')
                    ->with('error', 'سجل الدفع غير موجود أو غير مرتبط بالمستخدم.');
            }
            
            $paymentIntentId = $payment->payment_intent_id;
            if (!$paymentIntentId) {
                // Log::error('No payment_intent_id found in locker payment record', ['payment_id' => $paymentId]);
                return redirect()->route('min-alqalb.lockers.index')
                    ->with('error', 'معلومات الدفع غير صالحة.');
            }
            
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . config('ziina.api_key'),
                'Accept' => 'application/json',
            ])->get(config('ziina.api_url', 'https://api-v2.ziina.com/api') . '/payment_intent/' . $paymentIntentId);
            
            if ($response->successful()) {
                $paymentIntent = $response->json();
                // Log::info('Ziina payment intent response for locker', ['response' => $paymentIntent]);
                
                $payment->status = $paymentIntent['status'] ?? 'unknown';
                $payment->save();
                
                if (in_array($paymentIntent['status'], ['completed', 'succeeded'])) {
                    $lockerData = Session::get('locker_payment_' . $paymentId);
                    Session::forget('locker_payment_' . $paymentId);
                    Session::forget('pending_locker');
                    
                    if ($lockerData && isset($lockerData['locker_id'])) {
                        $locker = LocksWReadyCard::find($lockerData['locker_id']);
                        if (!$locker) {
                            // Log::error('Locker not found', ['locker_id' => $lockerData['locker_id']]);
                            return redirect()->route('min-alqalb.lockers.index')
                                ->with('error', 'القفل غير موجود.');
                        }
                        $user = User::find(Auth::id());
                        if (!$user) {
                            // Log::error('User not found', ['user_id' => Auth::id()]);
                            return redirect()->route('min-alqalb.lockers.index')
                                ->with('error', 'المستخدم غير موجود.');
                        }
                        
                        $request = \App\Models\Request::create([
                            'locks_w_ready_card_id' => $locker->id,
                            'user_id' => $user->id,
                            'name' => $user->name ?? null,
                            'email' => $user->email ?? null,
                            'address' => null,
                            'type' => 'lock',

                            'phone' => null,
                            'quantity' => $lockerData['quantity'],
                            'status' => 'pending',
                            'total_price' => $payment->amount,
                            'total_points' => 0,
                        ]);
                        
                        return redirect()->route('min-alqalb.lockers.index')
                            ->with('success', 'تم شراء القفل بنجاح! تم إضافة الطلب إلى قائمتك.');
                    } else {
                        // Log::error('No locker data found in session', [
                        //     'payment_id' => $paymentId,
                        //     'session_key' => 'locker_payment_' . $paymentId,
                        // ]);
                        return redirect()->route('min-alqalb.lockers.index')
                            ->with('error', 'معلومات القفل غير متوفرة. قد انتهت جلسة الدفع.');
                    }
                }
                
                // Log::warning('Locker payment not successful', [
                //     'payment_id' => $paymentId,
                //     'status' => $paymentIntent['status'],
                // ]);
                return redirect()->route('min-alqalb.lockers.index')
                    ->with('error', 'لم تكتمل عملية الدفع. يرجى المحاولة مرة أخرى.');
            } else {
                // Log::error('Ziina API request failed for locker', [
                //     'status' => $response->status(),
                //     'body' => $response->json(),
                // ]);
                throw new Exception('فشل التحقق من الدفع: ' . ($response->json()['message'] ?? 'خطأ غير معروف'));
            }
        } catch (Exception $e) {
            // Log::error('Error in locker handleSuccess', [
            //     'message' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            // ]);
            return redirect()->route('min-alqalb.lockers.index')
                ->with('error', 'خطأ أثناء التحقق من الدفع: ' . $e->getMessage());
        }
    }

    public function handleCancel(Request $request)
    {
        $paymentId = explode('_', $request->query('order_id', ''))[1] ?? null;
        
        if ($paymentId) {
            $payment = Payment::where('id', $paymentId)
                ->where('user_id', Auth::id())
                ->where('type', 'lock')
                ->first();
                
            if ($payment) {
                $payment->status = 'canceled';
                $payment->save();
            }
            Session::forget('locker_payment_' . $paymentId);
            Session::forget('pending_locker');
        }
        
        return redirect()->route('min-alqalb.lockers.index')
            ->with('info', 'تم إلغاء الدفع. يمكنك المحاولة مرة أخرى لاحقًا.');
    }
}