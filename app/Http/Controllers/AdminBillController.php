<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class AdminBillController extends Controller
{

    /**
     * Display a listing of all bills.
     */
    public function index()
    {
        $bills = Bill::with(['user', 'payment'])
            ->latest()
            ->get()
            ->map(function ($bill) {
                return [
                    'id' => $bill->id,
                    'user_name' => $bill->user ? $bill->user->name : __('unknown'),
                    'date' => $bill->created_at->format('d/m/Y'),
                    'subject' => $this->getSubject($bill),
                    'amount' => number_format($bill->amount, 2),
                    'status' => $this->getStatus($bill),
                    'currency' => $bill->currency,
                ];
            });

        return view('admin.bills.index', [
            'bills' => $bills,
            'statuses' => [__('all'), __('paid'), __('cancelled'), __('pending')]
        ]);
    }

    /**
     * Display the specified bill.
     */
    public function show(Bill $bill)
    {
        $bill->load(['user', 'payment']);

        return view('admin.bills.show', [
            'bill' => $bill,
            'subject' => $this->getSubject($bill),
            'status' => $this->getStatus($bill),
            'date' => $bill->created_at->format('d/m/Y'),
        ]);
    }

    /**
     * Generate and download a PDF for the specified bill.
     */
    public function generatePdf(Bill $bill)
    {
        try {
            $bill->load(['user', 'payment']);
            
            $fontPath = storage_path('fonts/Cairo-Regular.ttf');
            if (!file_exists($fontPath)) {
                Log::warning(__('cairo_font_not_found'), ['path' => $fontPath]);
            }

            $pdf = Pdf::loadView('app.bills.pdf', [
                'bill' => $bill,
                'subject' => $this->getSubject($bill),
                'status' => $this->getStatus($bill),
                'date' => $bill->created_at->format('d/m/Y'),
            ])
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'Cairo');

            return $pdf->download('invoice_' . $bill->id . '.pdf');
        } catch (\Exception $e) {
            Log::error(__('failed_to_generate_pdf'), [
                'bill_id' => $bill->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', __('failed_to_generate_pdf_error', ['message' => $e->getMessage()]));
        }
    }

    private function getStatus($bill)
    {
        switch ($bill->status) {
            case 'paid': return __('paid');
            case 'cancelled': return __('cancelled');
            case 'pending': return __('pending');
            default: return __('unknown');
        }
    }

    private function getSubject($bill)
    {
        switch ($bill->type) {
            case 'package': return __('purchase_points', ['quantity' => $bill->quantity]);
            case 'lock': return __('purchase_locks', ['quantity' => $bill->quantity]);
            case 'ready_card': return __('purchase_cards', ['quantity' => $bill->quantity]);
            default: return $bill->entity_name;
        }
    }
}