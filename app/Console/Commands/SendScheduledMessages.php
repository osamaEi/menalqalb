<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use Carbon\Carbon;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendScheduledMessages extends Command
{
    protected $signature = 'messages:send-scheduled';
    protected $description = 'Send scheduled messages that are due and have lock_type != no_lock';

    public function handle()
    {
        $now = Carbon::now();
        
        // Log::channel('scheduled_messages')->info('Starting scheduled messages processing', [
        //     'time' => $now->toDateTimeString(),
        // ]);

        // Get messages that need to be sent
        $messages = Message::where('status', 'scheduled')
            ->where('scheduled_at', '<=', $now)
            ->where('lock_type', '!=', 'no_lock')
            ->whereNotNull('recipient_phone')
            ->get();

        // Log::channel('scheduled_messages')->info('Found messages to process', [
        //     'count' => $messages->count(),
        // ]);

        $whatsAppService = new WhatsAppService();
        $sentCount = 0;
        $failedCount = 0;

        foreach ($messages as $message) {
            try {
                DB::beginTransaction();

                // Log::channel('scheduled_messages')->info('Processing message', [
                //     'message_id' => $message->id,
                //     'recipient_name' => $message->recipient_name,
                //     'recipient_phone' => $message->recipient_phone,
                //     'scheduled_at' => $message->scheduled_at,
                // ]);

                // Update message status to 'sent'
                $message->status = 'sent';
                
                // Log before sending WhatsApp
                // Log::channel('scheduled_messages')->debug('Sending WhatsApp message', [
                //     'message_id' => $message->id,
                //     'recipient_phone' => $message->recipient_phone,
                //     'template_data' => [
                //         'image_url' => 'https://minalqalb.ae/message.png',
                //         'recipient_name' => $message->recipient_name,
                //         'sender_name' => $message->sender_name,
                //         'message_lock' => $message->message_lock,
                //     ],
                // ]);

                // Send WhatsApp message
                $result = $whatsAppService->sendMinalqalnnewqTemplate(
                    $message->recipient_phone,
                    'https://minalqalb.ae/message.png',
                    $message->recipient_name,
                    $message->sender_name,
                    $message->message_lock
                );

                // Log WhatsApp response
                // Log::channel('scheduled_messages')->info('WhatsApp API response', [
                //     'message_id' => $message->id,
                //     'response' => $result,
                // ]);

                if (isset($result['response']['id'])) {
                    $message->whatsapp_message_id = $result['response']['id'];
                    $message->whatsapp_status = $result['response']['status'] ?? 'unknown';
                }
                
                $message->save();
                DB::commit();
                $sentCount++;

                // Log::channel('scheduled_messages')->info('Message processed successfully', [
                //     'message_id' => $message->id,
                // ]);
                
            } catch (\Exception $e) {
                DB::rollBack();
                $failedCount++;

                // Log::channel('scheduled_messages')->error('Failed to process message', [
                //     'message_id' => $message->id,
                //     'error' => $e->getMessage(),
                //     'trace' => $e->getTraceAsString(),
                // ]);
            }
        }

        $summary = [
            'total_processed' => $messages->count(),
            'sent_successfully' => $sentCount,
            'failed' => $failedCount,
            'processing_time' => Carbon::now()->diffInMilliseconds($now) . 'ms',
        ];

        // Log::channel('scheduled_messages')->info('Processing complete', $summary);

        $this->info(json_encode($summary, JSON_PRETTY_PRINT));
        return 0;
    }
}