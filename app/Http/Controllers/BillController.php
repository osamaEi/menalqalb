<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's bills.
     */
    public function index()
    {
        $bills = Bill::where('user_id', Auth::id())
            ->with(['payment', 'user'])
            ->latest()
            ->get()
            ->map(function ($bill) {
                return [
                    'id' => $bill->id,
                    'date' => $bill->created_at->format('d/m/Y'),
                    'subject' => $this->getSubject($bill),
                    'amount' => number_format($bill->amount, 2),
                    'status' => $this->getStatus($bill),
                    'action' => $bill->status === 'paid' ? 'تنزيل الفاتورة' : 'الدفع',
                    'action_class' => $bill->status === 'paid' ? 'action-download' : 'action-pay',
                    'currency' => $bill->currency,
                ];
            });

        return view('app.bills.index', [
            'bills' => $bills,
            'statuses' => ['الكل', 'مدفوعة', 'ملغاة', 'بانتظار الدفع']
        ]);
    }

    /**
     * Generate and download a PDF for the specified bill.
     */
    public function generatePdf(Bill $bill)
    {
        try {
            $bill->load(['user', 'payment']);
            
            // Verify font file exists
            $fontPath = storage_path('fonts/Cairo-Regular.ttf');
            if (!file_exists($fontPath)) {
                Log::warning('Cairo font not found, falling back to Helvetica', ['path' => $fontPath]);
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
            ->setOption('defaultFont', 'Cairo' );
    
            return $pdf->download('invoice_' . $bill->id . '.pdf');
        } catch (\Exception $e) {
            Log::error('Failed to generate PDF for bill', [
                'bill_id' => $bill->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    private function getStatus($bill)
    {
        switch ($bill->status) {
            case 'paid': return 'مدفوعة';
            case 'cancelled': return 'ملغاة';
            case 'pending': return 'بانتظار الدفع';
            default: return 'غير معروف';
        }
    }

    private function getSubject($bill)
    {
        switch ($bill->type) {
            case 'package': return 'شراء ' . $bill->quantity . ' نقطة';
            case 'lock': return 'شراء ' . $bill->quantity . ' قفل';
            case 'ready_card': return 'شراء ' . $bill->quantity . ' بطاقة';
            default: return $bill->entity_name;
        }
    }
}