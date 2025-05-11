<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use App\Models\ReadyCard;
use App\Models\ReadyCardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReadyCardController extends Controller
{
    /**
     * Display a listing of the ready cards with dashboard statistics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get statistics for dashboard
        $totalReadyCards = ReadyCard::count();
        $totalCardCount = ReadyCard::sum('card_count');
        $totalCost = ReadyCard::sum('cost');
        $uniqueCustomers = ReadyCard::distinct('customer_id')->count('customer_id');
        
        // Start with base query
        $query = ReadyCard::with(['customer']);
        
        // Apply filters
        if ($request->filled('customer_id')) {
            $query->byCustomer($request->customer_id);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        // Prepare filter description
        $filter = null;
        if ($request->filled('customer_id')) {
            $customer = User::find($request->customer_id);
            if ($customer) {
                $filter = __('Ready Cards for customer') . ': ' . $customer->name;
            }
        } elseif ($request->filled('date_from') || $request->filled('date_to')) {
            $filter = __('Ready Cards from') . ': ';
            if ($request->filled('date_from')) {
                $filter .= $request->date_from;
            }
            if ($request->filled('date_to')) {
                $filter .= ' ' . __('to') . ' ' . $request->date_to;
            }
        } elseif ($request->filled('search')) {
            $filter = __('Search results for') . ': ' . $request->search;
        }
        
        // Apply sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->newest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'cost_high':
                    $query->orderBy('cost', 'desc');
                    break;
                case 'cost_low':
                    $query->orderBy('cost', 'asc');
                    break;
                case 'card_count_high':
                    $query->orderBy('card_count', 'desc');
                    break;
                case 'card_count_low':
                    $query->orderBy('card_count', 'asc');
                    break;
                default:
                    $query->newest();
            }
        } else {
            $query->newest();
        }
        
        // Get paginated results
        $readyCards = $query->paginate(10)->withQueryString();
        
        // Get customers for filter dropdown
        $customers = User::whereHas('readyCards')->select('id', 'name')->get();
        
        return view('ready_cards.index', compact(
            'readyCards',
            'totalReadyCards',
            'totalCardCount',
            'totalCost',
            'uniqueCustomers',
            'customers',
            'filter'
        ));
    }

    /**
     * Show the form for creating a new ready card.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = User::orderBy('name')->get();
        $cards = Card::orderBy('id')->get();
        
        return view('ready_cards.create', compact('customers', 'cards'));
    }

    /**
     * Store a newly created ready card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'card_count' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0',
            'received_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
       
        // Handle image upload
        if ($request->hasFile('received_card_image')) {
            $path = $request->file('received_card_image')->store('ready_cards', 'public');
            $validated['received_card_image'] = $path;
        }
       
        DB::beginTransaction();
       
        try {
            // Create the ready card
            $readyCard = ReadyCard::create([
                'customer_id' => $validated['customer_id'],
                'card_count' => $validated['card_count'],
                'cost' => $validated['cost'],
                'received_card_image' => $validated['received_card_image'] ?? null,
            ]);
           
            // Create the individual card items based on card count
            for ($i = 1; $i <= $validated['card_count']; $i++) {
                // Generate a unique 6-digit serial number
                $serialNumber = $this->generateUniqueSerialNumber();
               
                // Generate unique letters for QR URL
                $uniqueLetters = $this->generateUniqueLetters();
               
                // Generate QR code content with URL
                $qrCodeContent = 'https://minalqalb.ae/' . $uniqueLetters;
               
                // Create the ready card item
                ReadyCardItem::create([
                    'ready_card_id' => $readyCard->id,
                    'sequence_number' => $serialNumber,
                    'identity_number' => str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT), // Keep the identity number as is
                    'qr_code' => $qrCodeContent,
                    'unique_identifier' => $uniqueLetters,
                    'status' => 'open' // Default status
                ]);
            }
           
            DB::commit();
           
            return redirect()->route('ready-cards.index')
                ->with('success', __('Ready card created successfully.'));
        } catch (\Exception $e) {
            DB::rollback();
           
            return redirect()->back()->withInput()
                ->with('error', __('Failed to create ready card.') . ' ' . $e->getMessage());
        }
    }
    
    /**
     * Generate a unique 6-digit serial number
     *
     * @return string
     */
    private function generateUniqueSerialNumber()
    {
        do {
            $serialNumber = str_pad(mt_rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $exists = ReadyCardItem::where('sequence_number', $serialNumber)->exists();
        } while ($exists);
        
        return $serialNumber;
    }
    
    /**
     * Generate unique letters for QR URL
     *
     * @return string
     */
    private function generateUniqueLetters()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $length = 8; // Adjust length as needed
        
        do {
            $uniqueLetters = '';
            for ($i = 0; $i < $length; $i++) {
                $uniqueLetters .= $characters[rand(0, strlen($characters) - 1)];
            }
            $exists = ReadyCardItem::where('unique_identifier', $uniqueLetters)->exists();
        } while ($exists);
        
        return $uniqueLetters;
    }

    /**
     * Display the specified ready card.
     *
     * @param  \App\Models\ReadyCard  $readyCard
     * @return \Illuminate\Http\Response
     */
    public function show(ReadyCard $readyCard)
    {
        $readyCard->load(['customer', 'items']);
        
        return view('ready_cards.show', compact('readyCard'));
    }

    /**
     * Show the form for editing the specified ready card.
     *
     * @param  \App\Models\ReadyCard  $readyCard
     * @return \Illuminate\Http\Response
     */
    public function edit(ReadyCard $readyCard)
    {
        $readyCard->load(['items']);
        $customers = User::orderBy('name')->get();
        $cards = Card::orderBy('id')->get();
        $selectedCards = $readyCard->items->pluck('card_id')->toArray();
        
        return view('ready_cards.edit', compact('readyCard', 'customers', 'cards', 'selectedCards'));
    }

    /**
     * Update the specified ready card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReadyCard  $readyCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReadyCard $readyCard)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:users,id',
            'cost' => 'nullable|numeric|min:0',
            'received_card_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('received_card_image')) {
            // Delete old image if exists
            if ($readyCard->received_card_image) {
                Storage::disk('public')->delete($readyCard->received_card_image);
            }
            
            $path = $request->file('received_card_image')->store('ready_cards', 'public');
            $validated['received_card_image'] = $path;
        }
      
            // Only update the customer, cost, and image (if provided)
            $readyCard->update([
                'customer_id' => $validated['customer_id'],
                'cost' => $validated['cost'],
                'received_card_image' => $validated['received_card_image'] ?? $readyCard->received_card_image,
            ]);
            
            return redirect()->route('ready-cards.index')
                ->with('success', __('Ready card details updated successfully.'));
       
            
        }
    /**
     * Remove the specified ready card from storage.
     *
     * @param  \App\Models\ReadyCard  $readyCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReadyCard $readyCard)
    {
        // Delete image if exists
        if ($readyCard->received_card_image) {
            Storage::disk('public')->delete($readyCard->received_card_image);
        }
        
        // Delete the ready card (items will be deleted via cascade)
        $readyCard->delete();
        
        return redirect()->route('ready-cards.index')
            ->with('success', __('Ready card deleted successfully.'));
    }
    
    /**
     * Filter ready cards by customer.
     *
     * @param  int  $customerId
     * @return \Illuminate\Http\Response
     */
    public function filterByCustomer($customerId)
    {
        $customer = User::findOrFail($customerId);
        
        // Get statistics for dashboard
        $totalReadyCards = ReadyCard::count();
        $totalCardCount = ReadyCard::sum('card_count');
        $totalCost = ReadyCard::sum('cost');
        $uniqueCustomers = ReadyCard::distinct('customer_id')->count('customer_id');
        
        // Get filtered ready cards
        $readyCards = ReadyCard::with(['customer'])
            ->byCustomer($customerId)
            ->newest()
            ->paginate(10);
        
        // Get customers for filter dropdown
        $customers = User::whereHas('readyCards')->select('id', 'name')->get();
        
        return view('ready_cards.index', compact(
            'readyCards',
            'totalReadyCards',
            'totalCardCount',
            'totalCost',
            'uniqueCustomers',
            'customers'
        ))->with('filter', __('Ready Cards for customer') . ': ' . $customer->name);
    }
    
    /**
     * Filter ready cards by date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterByDate(Request $request)
    {
        $validated = $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);
        
        return redirect()->route('ready_cards.index', [
            'date_from' => $validated['date_from'],
            'date_to' => $validated['date_to'],
        ]);
    }

    /**
 * Get items for a ready card.
 *
 * @param  \App\Models\ReadyCard  $readyCard
 * @return \Illuminate\Http\Response
 */
public function getItems(ReadyCard $readyCard)
{
    $items = $readyCard->items()->orderBy('sequence_number')->get();
    
    return response()->json([
        'success' => true,
        'items' => $items
    ]);
}

/**
 * Print all cards for a ready card.
 *
 * @param  \App\Models\ReadyCard  $readyCard
 * @return \Illuminate\Http\Response
 */
/**
 * Print all cards for a ready card as an Excel sheet.
 *
 * @param  \App\Models\ReadyCard  $readyCard
 * @return \Illuminate\Http\Response
 */
/**
 * Print all cards for a ready card as an Excel sheet with QR code text (not images).
 *
 * @param  \App\Models\ReadyCard  $readyCard
 * @return \Illuminate\Http\Response
 */
public function printAllCards(ReadyCard $readyCard)
{
    // Get all items ordered by sequence number
    $items = $readyCard->items()->orderBy('sequence_number')->get();
    
    // Create a new Excel file
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set column headers
    $sheet->setCellValue('A1', 'Sequence #');
    $sheet->setCellValue('B1', 'Identity #');
    $sheet->setCellValue('C1', 'QR Code');
    
    // Style headers
    $headerStyle = [
        'font' => [
            'bold' => true,
            'size' => 12
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'rgb' => 'E2EFDA',
            ],
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];
    $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
    
    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(30);  // Wider for QR code text
    $sheet->getColumnDimension('D')->setWidth(12);
    
    // No need for extra row height since we're just displaying text
    $sheet->getDefaultRowDimension()->setRowHeight(20);
    
    // Add data rows with QR codes as text
    $row = 2;
    foreach ($items as $item) {
        $sheet->setCellValue('A' . $row, $item->sequence_number);
        $sheet->setCellValue('B' . $row, $item->identity_number);
        $sheet->setCellValue('C' . $row, $item->qr_code);  // Just add the QR code text from database
        
        // Set text alignment for readability
        $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
        
        // Style for data rows
        $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);
        
      
        $row++;
    }
    
    // Create Excel writer
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    
    // Set the file name with customer name and date
    $fileName = 'ReadyCards_' . preg_replace('/[^a-zA-Z0-9]/', '_', $readyCard->customer->name) . '_' . date('Y-m-d') . '.xlsx';
    
    // Create response with headers for Excel download
    $response = response()->stream(
        function() use ($writer) {
            $writer->save('php://output');
        },
        200,
        [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]
    );
    
    return $response;
}

}