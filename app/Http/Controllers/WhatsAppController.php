<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    /**
     * Send WhatsApp templates using the WhatsAppService
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendTemplates(Request $request)
    {
        // Initialize the WhatsApp service
        $whatsAppService = new WhatsAppService();
        $result = null;
        
        try {
            // Get the template type from request or default to 'minalqalnnewq'
            $templateType = $request->input('template_type', 'minalqalnnewq');
            
            // Determine which template to send based on the request
            switch ($templateType) {
                case 'minalqalnnewq':
                    $result = $whatsAppService->sendMinalqalnnewqTemplate(
                        $request->input('phone_number', '971501774477'),
                        $request->input('image_url', 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=500'),
                        $request->input('body_text_1', 'osame'),
                        $request->input('body_text_2', 'eid'),
                        $request->input('body_text_3', 'bakry')
                    );
                    break;
                    
                case 'feelings':
                    $result = $whatsAppService->sendFeelingsTemplate(
                        $request->input('phone_number', '971501774477'),
                        $request->input('image_url', 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=500'),
                        $request->input('body_text_1', 'mahmoud')
                    );
                    break;
                    
                case 'custom':
                    // Build body parameters
                    $bodyParams = [];
                    if ($request->has('body_text_1')) {
                        $bodyParams[] = WhatsAppService::createTextParameter($request->input('body_text_1'));
                    }
                    if ($request->has('body_text_2')) {
                        $bodyParams[] = WhatsAppService::createTextParameter($request->input('body_text_2'));
                    }
                    if ($request->has('body_text_3')) {
                        $bodyParams[] = WhatsAppService::createTextParameter($request->input('body_text_3'));
                    }
                    
                    // Build header parameters with image
                    $headerParams = [
                        WhatsAppService::createImageParameter($request->input('image_url', url('whats.jpg')))
                    ];
                    
                    $result = $whatsAppService->sendCustomTemplate(
                        $request->input('phone_number', '971501774477'),
                        $request->input('template_name', 'custom_template'),
                        $request->input('language_code', 'ar'),
                        $bodyParams,
                        $headerParams
                    );
                    break;
            }
            
            // Check result and return appropriate response
            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Message sent successfully!',
                    'data' => $result['response'] ?? null
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send message',
                    'error' => $result['error'] ?? 'Unknown error'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the message',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function testConnection()
    {
         $test = asset('whats.jpg');

         return response()->json([
            'photo' => $test
         ]);
    }
}