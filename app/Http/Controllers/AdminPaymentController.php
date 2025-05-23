<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPaymentController extends Controller
{
   

    /**
     * Display a listing of all payments.
     */
    public function index()
    {
        $payments = Payment::with('user')
            ->latest()
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->order_id,
                    'user_name' => $payment->user ? $payment->user->name : __('unknown'),
                    'date' => $payment->created_at->format('d/m/Y H:i'),
                    'subject' => $this->getSubject($payment),
                    'amount' => number_format($payment->amount, 2),
                    'currency' => $payment->currency,
                    'status' => $this->getStatus($payment),
                    'payment_intent_id' => $payment->payment_intent_id,
                    'redirect_url' => $payment->redirect_url,
                ];
            });

        return view('admin.payments.index', [
            'payments' => $payments,
        ]);
    }

    private function getStatus($payment)
    {
        switch ($payment->status) {
            case 'succeeded': return __('succeeded');
            case 'failed': return __('failed');
            case 'pending': return __('pending');
            default: return __('unknown');
        }
    }

    private function getSubject($payment)
    {
        switch ($payment->type) {
            case 'package': return __('purchase_points', ['quantity' => 1]);
            case 'card': return __('purchase_cards', ['quantity' => 1]);
            case 'lock': return __('purchase_locks', ['quantity' => 1]);
            default: return __('unknown_transaction');
        }
    }
}