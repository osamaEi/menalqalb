<?php

namespace App\Observers;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\Package;
use App\Models\LocksWReadyCard;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment)
    {
        // Check if payment status is completed or succeeded
        if (in_array($payment->status, ['completed', 'succeeded'])) {
            try {
                // Determine the entity details based on payment type
                $entityData = $this->getEntityData($payment);

                // Create a bill
                Bill::create([
                    'user_id' => $payment->user_id,
                    'payment_id' => $payment->id,
                    'type' => $payment->type,
                    'entity_id' => $entityData['entity_id'] ?? null,
                    'entity_name' => $entityData['entity_name'] ?? 'Unknown',
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'quantity' => $entityData['quantity'] ?? 1,
                    'status' => 'generated',
                ]);

                Log::info('Bill created for payment', [
                    'payment_id' => $payment->id,
                    'type' => $payment->type,
                    'user_id' => $payment->user_id,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create bill for payment', [
                    'payment_id' => $payment->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Get entity data based on payment type.
     */
    private function getEntityData(Payment $payment): array
    {
        $data = [
            'entity_id' => null,
            'entity_name' => null,
            'quantity' => 1,
        ];

        if ($payment->type === 'package') {
            $packageId = Session::get('payment_package_' . $payment->id);
            if ($packageId) {
                $package = Package::find($packageId);
                if ($package) {
                    $data['entity_id'] = $package->id;
                    $data['entity_name'] = $package->title ?? 'Package ' . $package->id;
                }
            }
        } elseif (in_array($payment->type, ['lock', 'ready_card'])) {
            $lockerData = Session::get('locker_payment_' . $payment->id);
            if ($lockerData && isset($lockerData['locker_id'])) {
                $locker = LocksWReadyCard::find($lockerData['locker_id']);
                if ($locker) {
                    $data['entity_id'] = $locker->id;
                    $data['entity_name'] = $locker->name_ar ?? 'Locker ID: ' . $locker->id;
                    $data['quantity'] = $lockerData['quantity'] ?? 1;
                }
            }
        }

        return $data;
    }
}