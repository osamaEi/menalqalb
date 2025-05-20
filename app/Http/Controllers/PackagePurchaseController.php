<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use App\Services\ZiinaPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PackagePurchaseController extends Controller
{
    /**
     * @var ZiinaPaymentService
     */
    protected $ziinaService;

    /**
     * Create a new controller instance.
     */
    public function __construct(ZiinaPaymentService $ziinaService)
    {
        $this->middleware('auth');
        $this->ziinaService = $ziinaService;
    }

    /**
     * Display all available packages.
     */
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        
        return view('admin.purchase.index', compact('packages'));
    }

    /**
     * Handle package purchase request.
     */
    public function purchase(Request $request, $id)
    {
        $package = Package::where('is_active', true)->findOrFail($id);
        
        DB::beginTransaction();
        
        try {
            // Create payment record
            $payment = new Payment();
            $payment->user_id = Auth::id();
            $payment->amount = $package->price;
            $payment->currency = 'AED';
            $payment->type = 'package';
            $payment->status = 'pending';
            $payment->save();
            
            // Convert price from AED to fils for Ziina (1 AED = 100 fils)
            $amountInFils = (int)($package->price * 100);
            
            // Create payment intent - directly using HTTP
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . config('ziina.api_key'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('ziina.api_url', 'https://api-v2.ziina.com/api') . '/payment_intent', [
                'amount' => $amountInFils,
                'currency_code' => 'AED', // Changed from 'currency' to 'currency_code'
                'success_url' => route('packages.payment.success', [
                    'order_id' => 'pkg_' . $payment->id,
                    'payment_intent_id' => '{PAYMENT_INTENT_ID}'
                ]),
                'cancel_url' => route('packages.payment.cancel', [
                    'order_id' => 'pkg_' . $payment->id
                ]),
                'description' => 'Package: ' . $package->title,
                'test' => config('ziina.test_mode', true),
                'metadata' => [
                    'package_id' => (string)$package->id,
                    'user_id' => (string)Auth::id(),
                    'payment_type' => 'package'
                ]
            ]);
            
            // Log the raw response
            Log::info('Ziina API response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);
            
            // Check if request was successful
            if ($response->successful()) {
                $paymentIntent = $response->json();
                
                // Update payment record
                $payment->payment_intent_id = $paymentIntent['id'];
                if (isset($paymentIntent['redirect_url'])) {
                    $payment->redirect_url = $paymentIntent['redirect_url'];
                }
                $payment->save();
                
                // Redirect to Ziina payment page
                return redirect($paymentIntent['redirect_url']);
                
            } else {
                // Handle error properly to avoid Array to string conversion
                $responseData = $response->json();
                $errorMessage = 'Unknown error from payment gateway';
                
                // Extract error message carefully
                if (isset($responseData['message'])) {
                    if (is_array($responseData['message'])) {
                        // Join array of error messages
                        $errorMessage = implode(', ', $responseData['message']);
                    } else {
                        $errorMessage = $responseData['message'];
                    }
                } elseif (isset($responseData['error'])) {
                    $errorMessage = $responseData['error'];
                }
                
                throw new Exception('Payment gateway error: ' . $errorMessage);
            }
            
        } catch (Exception $e) {
            DB::rollBack();
            
            // Log the exception
            Log::error('Payment processing exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('purchase.index')
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment.
     */
    public function handleSuccess(Request $request)
    {
        $paymentId = explode('_', $request->order_id)[1] ?? null;
        $paymentIntentId = $request->payment_intent_id;
        
        if (!$paymentId || !$paymentIntentId) {
            return redirect()->route('purchase.index')
                ->with('error', 'Invalid payment information.');
        }
        
        $payment = Payment::where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        try {
            // Get payment intent status directly
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . config('ziina.api_key'),
                'Accept' => 'application/json',
            ])->get(config('ziina.api_url', 'https://api-v2.ziina.com/api') . '/payment_intent/' . $paymentIntentId);
            
            if ($response->successful()) {
                $paymentIntent = $response->json();
                
                // Update payment record
                $payment->status = $paymentIntent['status'];
                $payment->save();
                
                // If payment is successful, credit user
                if ($paymentIntent['status'] === 'succeeded') {
                    // Get package from metadata
                    $packageId = $paymentIntent['metadata']['package_id'] ?? null;
                    
                    if ($packageId) {
                        $package = Package::findOrFail($packageId);
                        
                        // Credit the user
                        $user = User::find(Auth::id());
                        $user->credit_package = $user->credit_package + $package->amount;
                        $user->save();
                        
                        return redirect()->route('purchase.index')
                            ->with('success', 'Package purchased successfully! ' . $package->amount . ' credits have been added to your account.');
                    }
                }
            }
            
            return redirect()->route('purchase.index')
                ->with('error', 'Payment was not successful. Please try again.');
                
        } catch (Exception $e) {
            return redirect()->route('purchase.index')
                ->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle cancelled payment.
     */
    public function handleCancel(Request $request)
    {
        $paymentId = explode('_', $request->order_id)[1] ?? null;
        
        if ($paymentId) {
            $payment = Payment::where('id', $paymentId)
                ->where('user_id', Auth::id())
                ->first();
                
            if ($payment) {
                $payment->status = 'cancelled';
                $payment->save();
            }
        }
        
        return redirect()->route('purchase.index')
            ->with('info', 'Payment was cancelled. You can try again when ready.');
    }
}