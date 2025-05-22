<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;

class PackagePurchaseController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all available packages.
     */
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        return view('app.purchase.index', compact('packages'));
    }

    /**
     * Handle package purchase request.
     */
    public function purchase(Request $request, $id)
    {
        $package = Package::where('is_active', true)->findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // Ensure authenticated user
            if (!Auth::check()) {
                throw new Exception('المستخدم غير مصادق عليه.');
            }
            
            // Create payment record
            $payment = new Payment();
            $payment->user_id = Auth::id();
            $payment->amount = $package->price;
            $payment->currency = 'AED';
            $payment->type = 'package';
            $payment->status = 'pending';
            $payment->save();
            
            // Store package_id in session
            Session::put('payment_package_' . $payment->id, $package->id);
            
            // Convert price from AED to fils for Ziina (1 AED = 100 fils)
            $amountInFils = (int)($package->price * 100);
            
            // Create payment intent
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . config('ziina.api_key'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('ziina.api_url', 'https://api-v2.ziina.com/api') . '/payment_intent', [
                'amount' => $amountInFils,
                'currency_code' => 'AED',
                'success_url' => route('packages.payment.success', ['order_id' => 'pkg_' . $payment->id]),
                'cancel_url' => route('packages.payment.cancel', ['order_id' => 'pkg_' . $payment->id]),
                'description' => 'Package Purchase: Title=' . ($package->title ?? 'Package ' . $package->id),
                'test' => config('ziina.test_mode', true),
                'metadata' => [
                    'package_id' => (string)$package->id,
                    'user_id' => (string)Auth::id(),
                    'payment_type' => 'package',
                ],
            ]);
            
            // Log the raw response
            Log::info('Ziina API response in purchase', [
                'status' => $response->status(),
                'body' => $response->json(),
                'request_body' => [
                    'amount' => $amountInFils,
                    'currency_code' => 'AED',
                    'success_url' => route('packages.payment.success', ['order_id' => 'pkg_' . $payment->id]),
                    'cancel_url' => route('packages.payment.cancel', ['order_id' => 'pkg_' . $payment->id]),
                    'description' => 'Package Purchase: Title=' . ($package->title ?? 'Package ' . $package->id),
                    'test' => config('ziina.test_mode', true),
                    'metadata' => [
                        'package_id' => (string)$package->id,
                        'user_id' => (string)Auth::id(),
                        'payment_type' => 'package',
                    ],
                ],
            ]);
            
            // Check if request was successful
            if ($response->successful()) {
                $paymentIntent = $response->json();
                
                // Verify payment intent ID and redirect URL
                if (!isset($paymentIntent['id']) || !isset($paymentIntent['redirect_url'])) {
                    Log::error('Invalid payment intent response', ['response' => $paymentIntent]);
                    throw new Exception('فشل في استرجاع معرف نية الدفع أو رابط الإعادة التوجيه');
                }
                
                // Update payment record
                $payment->payment_intent_id = $paymentIntent['id'];
                $payment->redirect_url = $paymentIntent['redirect_url'];
                $payment->save();
                
                DB::commit();
                
                // Redirect to Ziina payment page
                return redirect($paymentIntent['redirect_url']);
            } else {
                $responseData = $response->json();
                $errorMessage = isset($responseData['message']) 
                    ? (is_array($responseData['message']) ? implode(', ', $responseData['message']) : $responseData['message'])
                    : ($responseData['error'] ?? 'خطأ غير معروف من بوابة الدفع');
                
                Log::error('Ziina API error', ['error' => $errorMessage]);
                throw new Exception('خطأ بوابة الدفع: ' . $errorMessage);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Payment processing exception in purchase', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('packages.index')
                ->with('error', 'فشل معالجة الدفع: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment.
     */
    public function handleSuccess(Request $request)
    {
        $paymentId = explode('_', $request->query('order_id', ''))[1] ?? null;
        
        if (!$paymentId) {
            Log::error('Invalid order_id in handleSuccess', ['order_id' => $request->query('order_id')]);
            return redirect()->route('packages.index')
                ->with('error', 'معلومات الدفع غير صالحة.');
        }
        
        try {
            $payment = Payment::where('id', $paymentId)
                ->where('user_id', Auth::id())
                ->first();
            
            if (!$payment) {
                Log::error('Payment record not found or user mismatch', [
                    'payment_id' => $paymentId,
                    'user_id' => Auth::id(),
                ]);
                return redirect()->route('packages.index')
                    ->with('error', 'سجل الدفع غير موجود أو غير مرتبط بالمستخدم.');
            }
            
            $paymentIntentId = $payment->payment_intent_id;
            if (!$paymentIntentId) {
                Log::error('No payment_intent_id found in payment record', ['payment_id' => $paymentId]);
                return redirect()->route('packages.index')
                    ->with('error', 'معلومات الدفع غير صالحة.');
            }
            
            // Get payment intent status
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . config('ziina.api_key'),
                'Accept' => 'application/json',
            ])->get(config('ziina.api_url', 'https://api-v2.ziina.com/api') . '/payment_intent/' . $paymentIntentId);
            
            if ($response->successful()) {
                $paymentIntent = $response->json();
                Log::info('Ziina payment intent response', ['response' => $paymentIntent]);
                
                // Update payment record
                $payment->status = $paymentIntent['status'] ?? 'unknown';
                $payment->save();
                
                // If payment is successful, credit user
                if (in_array($paymentIntent['status'], ['completed', 'succeeded'])) {
                    // Retrieve package_id from session
                    $packageId = Session::get('payment_package_' . $paymentId);
                    
                    // Clear session data
                    Session::forget('payment_package_' . $paymentId);
                    
                    if ($packageId) {
                        $package = Package::find($packageId);
                        if (!$package) {
                            Log::error('Package not found', ['package_id' => $packageId]);
                            return redirect()->route('packages.index')
                                ->with('error', 'الباقة غير موجودة.');
                        }
                        $user = User::find(Auth::id());
                        if (!$user) {
                            Log::error('User not found', ['user_id' => Auth::id()]);
                            return redirect()->route('packages.index')
                                ->with('error', 'المستخدم غير موجود.');
                        }
                        $user->credits_package = ($user->credits_package ?? 0) + $package->amount;
                        $user->save();
                        
                        return redirect()->route('packages.index')
                            ->with('success', 'تم شراء الباقة بنجاح! تم إضافة ' . $package->amount . ' نقطة إلى حسابك.');
                    } else {
                        Log::error('No package_id found in session', [
                            'payment_id' => $paymentId,
                            'session_key' => 'payment_package_' . $paymentId,
                        ]);
                        return redirect()->route('packages.index')
                            ->with('error', 'معلومات الباقة غير متوفرة. قد انتهت جلسة الدفع.');
                    }
                }
                
                Log::warning('Payment not successful', [
                    'payment_id' => $paymentId,
                    'status' => $paymentIntent['status'],
                ]);
                return redirect()->route('packages.index')
                    ->with('error', 'لم تكتمل عملية الدفع. يرجى المحاولة مرة أخرى.');
            } else {
                Log::error('Ziina API request failed', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);
                throw new Exception('فشل التحقق من الدفع: ' . ($response->json()['message'] ?? 'خطأ غير معروف'));
            }
        } catch (Exception $e) {
            Log::error('Error in handleSuccess', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('packages.index')
                ->with('error', 'خطأ أثناء التحقق من الدفع: ' . $e->getMessage());
        }
    }

    /**
     * Handle cancelled payment.
     */
    public function handleCancel(Request $request)
    {
        $paymentId = explode('_', $request->query('order_id', ''))[1] ?? null;
        
        if ($paymentId) {
            $payment = Payment::where('id', $paymentId)
                ->where('user_id', Auth::id())
                ->first();
                
            if ($payment) {
                $payment->status = 'cancelled';
                $payment->save();
            }
            // Clear session data
            Session::forget('payment_package_' . $paymentId);
        }
        
        return redirect()->route('packages.index')
            ->with('info', 'تم إلغاء الدفع. يمكنك المحاولة مرة أخرى لاحقًا.');
    }
}