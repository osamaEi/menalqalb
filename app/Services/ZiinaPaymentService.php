<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ZiinaPaymentService
{
    /**
     * @var string
     */
    protected $apiUrl;
    
    /**
     * @var string
     */
    protected $apiKey;
    
    /**
     * @var bool
     */
    protected $testMode;

    /**
     * Initialize the Ziina service with configuration
     */
    public function __construct()
    {
        $this->apiUrl = config('ziina.api_url', 'https://api-v2.ziina.com/api');
        $this->apiKey = config('ziina.api_key');
        $this->testMode = config('ziina.test_mode', true);
    }

    /**
     * Create a payment intent with Ziina API
     *
     * @param int $amount Amount in fils (1 AED = 100 fils)
     * @param string $orderId
     * @param array $options Additional options
     * @return array Payment intent data
     * @throws \Exception If API request fails
     */
    public function createPaymentIntent(int $amount, string $orderId, array $options = [])
    {
        // Ensure minimum amount (2 AED = 200 fils)
        if ($amount < 200) {
            throw new Exception('The minimum payment amount is 2 AED (200 fils)');
        }

        // Prepare success and cancel URLs
        $successUrl = route('packages.payment.success', [
            'order_id' => $orderId,
            'payment_intent_id' => '{PAYMENT_INTENT_ID}'
        ]);
        
        $cancelUrl = route('packages.payment.cancel', ['order_id' => $orderId]);

        // Prepare metadata
        $metadata = [];
        if (isset($options['metadata']) && is_array($options['metadata'])) {
            foreach ($options['metadata'] as $key => $value) {
                // Convert all metadata values to strings
                $metadata[$key] = (string)$value;
            }
        }
        
        // Use the string-converted metadata
        if (count($metadata) > 0) {
            $options['metadata'] = $metadata;
        }

        // Build request payload with string values
        $payload = array_merge([
            'amount' => $amount,
            'currency' => 'AED',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'test' => $this->testMode ? true : false, // Ensure boolean
        ], $options);

        // Debug the payload before sending
        Log::debug('Ziina payment intent payload', [
            'payload' => $payload
        ]);

        try {
            // Make API request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/payment_intent', $payload);

            // Log the response 
            Log::debug('Ziina payment intent response', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);
            
            // Process response
            if ($response->successful()) {
                return $response->json();
            } else {
                $errorData = $response->json();
                Log::error('Ziina payment intent creation failed', [
                    'error' => $errorData,
                    'status' => $response->status(),
                ]);
                
                throw new Exception('Failed to create payment: ' . 
                    ($errorData['message'] ?? 'Unknown error'));
            }
        } catch (Exception $e) {
            Log::error('Exception creating Ziina payment intent', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Get payment intent details by ID
     *
     * @param string $paymentIntentId
     * @return array Payment intent data
     * @throws \Exception If API request fails
     */
    public function getPaymentIntent(string $paymentIntentId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ])->get($this->apiUrl . '/payment_intent/' . $paymentIntentId);

            // Log the response 
            Log::debug('Ziina get payment intent response', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);
            
            if ($response->successful()) {
                return $response->json();
            } else {
                $errorData = $response->json();
                Log::error('Failed to retrieve Ziina payment intent', [
                    'payment_intent_id' => $paymentIntentId,
                    'status' => $response->status(),
                    'error' => $errorData
                ]);
                
                throw new Exception('Failed to retrieve payment details: ' . 
                    ($errorData['message'] ?? 'Unknown error'));
            }
        } catch (Exception $e) {
            Log::error('Exception retrieving Ziina payment intent', [
                'payment_intent_id' => $paymentIntentId,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}