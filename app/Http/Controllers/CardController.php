<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Category;
use App\Models\CardType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CardController extends Controller
{
    /**
     * Display a listing of the cards with dashboard statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Initialize the card query
        $cardQuery = Card::with(['user', 'cardType', 'mainCategory', 'subCategory']);
        
        // Apply filters if form is submitted
        if ($request->has('_filter')) {
            // Apply filters
            if ($request->filled('card_type')) {
                $cardQuery->where('card_type_id', $request->card_type);
            }
            
            if ($request->filled('language')) {
                $cardQuery->where('language', $request->language);
            }
            
            if ($request->filled('category')) {
                $cardQuery->where('main_category_id', $request->category);
            }
            
            if ($request->filled('designer')) {
                $cardQuery->where('user_id', $request->designer);
            }
            
            if ($request->filled('status')) {
                if ($request->status == 'active') {
                    $cardQuery->active();
                } elseif ($request->status == 'inactive') {
                    $cardQuery->inactive();
                }
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $cardQuery->where(function($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                });
            }
            
            // Set filter title for display
            $filter = __('Filtered Cards');
        } else {
            // Set default title if not filtering
            $filter = __('Recent Cards');
        }
        
        // Get statistics for dashboard
        $totalCards = Card::count();
        $activeCards = Card::active()->count();
        $inactiveCards = Card::inactive()->count();
        
        // Get cards by type statistics
        $cardsByType = CardType::withCount('cards')->get();
        
        // Get most used cards
        $mostUsedCards = Card::orderBy('usage_count', 'desc')->take(5)->get();
        
        // Execute the query with pagination
        $recentCards = $cardQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Get main categories, subcategories and card types for filtering
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $designers = User::where('user_type', 'designer')->get();
        $languages = Card::getLanguageOptions();
        
        return view('cards.index', compact(
            'recentCards',
            'totalCards',
            'activeCards',
            'inactiveCards',
            'cardsByType',
            'mostUsedCards',
            'mainCategories',
            'cardTypes',
            'designers',
            'languages',
            'filter'
        ));
    }
    /**
     * Show the form for creating a new card.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $languages = Card::getLanguageOptions();
        
        return view('cards.create', compact('mainCategories', 'cardTypes', 'languages'));
    }

    /**
     * Store a newly created card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required|string|max:10',
            'main_category_id' => 'required|exists:categories,id',
            'sub_category_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value) {
                        $subCategory = Category::find($value);
                        if (!$subCategory || $subCategory->is_main || $subCategory->parent_id != $request->main_category_id) {
                            $fail(__('The selected subcategory is invalid.'));
                        }
                    }
                },
            ],
            'card_type_id' => 'required|exists:card_types,id',
            'selling_price' => 'required|numeric|min:0',
            'file' => [
                'required',
                'file',
                'max:20480', // 20MB max file size
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->has('card_type_id')) {
                        $cardType = CardType::find($request->card_type_id);
                        if ($cardType) {
                            $mimeType = $value->getMimeType();
                            $extension = $value->getClientOriginalExtension();
                            
                            // Validate based on card type
                            if ($cardType->type === 'image') {
                                $validMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/svg+xml'];
                                if (!in_array($mimeType, $validMimes)) {
                                    $fail(__('The file must be an image for image card type.'));
                                }
                            } elseif ($cardType->type === 'video') {
                                $validMimes = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-flv', 'video/webm'];
                                if (!in_array($mimeType, $validMimes)) {
                                    $fail(__('The file must be a video for video card type.'));
                                }
                            } elseif ($cardType->type === 'animated_image') {
                                $validExtensions = ['gif', 'webp'];
                                if (!in_array(strtolower($extension), $validExtensions)) {
                                    $fail(__('The file must be an animated image (GIF or WebP) for animated image card type.'));
                                }
                            }
                        }
                    }
                },
            ],
            'is_active' => 'boolean',
        ]);
        
        // Set user ID (designer)
        $validated['user_id'] = Auth::id();
        
        // Set default values
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['usage_count'] = 0;
        
        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('cards', 'public');
            $validated['file_path'] = $filePath;
        }
        
        $card = Card::create($validated);
        
        return redirect()->route('cards.index')
            ->with('success', __('Card created successfully.'));
    }

    /**
     * Display the specified card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        $card->load(['user', 'cardType', 'mainCategory', 'subCategory']);
        $languages = Card::getLanguageOptions();
        
        return view('cards.show', compact('card', 'languages'));
    }

    /**
     * Show the form for editing the specified card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $subcategories = Category::where('parent_id', $card->main_category_id)
            ->where('is_active', true)
            ->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $languages = Card::getLanguageOptions();
        
        return view('cards.edit', compact('card', 'mainCategories', 'subcategories', 'cardTypes', 'languages'));
    }

    /**
     * Update the specified card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required|string|max:10',
            'main_category_id' => 'required|exists:categories,id',
            'sub_category_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value) {
                        $subCategory = Category::find($value);
                        if (!$subCategory || $subCategory->is_main || $subCategory->parent_id != $request->main_category_id) {
                            $fail(__('The selected subcategory is invalid.'));
                        }
                    }
                },
            ],
            'card_type_id' => 'required|exists:card_types,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'file' => [
                'nullable',
                'file',
                'max:20480', // 20MB max file size
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->has('card_type_id') && $value) {
                        $cardType = CardType::find($request->card_type_id);
                        if ($cardType) {
                            $mimeType = $value->getMimeType();
                            $extension = $value->getClientOriginalExtension();
                            
                            // Validate based on card type
                            if ($cardType->type === 'image') {
                                $validMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/svg+xml'];
                                if (!in_array($mimeType, $validMimes)) {
                                    $fail(__('The file must be an image for image card type.'));
                                }
                            } elseif ($cardType->type === 'video') {
                                $validMimes = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-flv', 'video/webm'];
                                if (!in_array($mimeType, $validMimes)) {
                                    $fail(__('The file must be a video for video card type.'));
                                }
                            } elseif ($cardType->type === 'animated_image') {
                                $validExtensions = ['gif', 'webp'];
                                if (!in_array(strtolower($extension), $validExtensions)) {
                                    $fail(__('The file must be an animated image (GIF or WebP) for animated image card type.'));
                                }
                            }
                        }
                    }
                },
            ],
            'is_active' => 'boolean',
        ]);
        
        // Set default values
        $validated['is_active'] = $request->boolean('is_active', true);
        
        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($card->file_path) {
                Storage::disk('public')->delete($card->file_path);
            }
            
            $file = $request->file('file');
            $filePath = $file->store('cards', 'public');
            $validated['file_path'] = $filePath;
        }
        
        $card->update($validated);
        
        return redirect()->route('cards.index')
            ->with('success', __('Card updated successfully.'));
    }

    /**
     * Remove the specified card from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        // Check if card has any ready cards
        if ($card->readyCards()->count() > 0) {
            return redirect()->route('cards.index')
                ->with('error', __('Cannot delete a card that has been used in ready cards.'));
        }
        
        // Delete file
        if ($card->file_path) {
            Storage::disk('public')->delete($card->file_path);
        }
        
        $card->delete();
        
        return redirect()->route('cards.index')
            ->with('success', __('Card deleted successfully.'));
    }
    
    /**
     * Toggle card active status.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Card $card)
    {
        $card->update(['is_active' => !$card->is_active]);
        
        $message = $card->is_active ? 
            __('Card has been activated.') : 
            __('Card has been deactivated.');
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Filter cards by type.
     *
     * @param  int  $cardTypeId
     * @return \Illuminate\Http\Response
     */
    public function filterByType($cardTypeId)
    {
        $cardType = CardType::findOrFail($cardTypeId);
        
        // Get statistics for dashboard
        $totalCards = Card::count();
        $activeCards = Card::active()->count();
        $inactiveCards = Card::inactive()->count();
        
        // Get cards by type statistics
        $cardsByType = CardType::withCount('cards')->get();
        
        // Get most used cards
        $mostUsedCards = Card::orderBy('usage_count', 'desc')->take(5)->get();
        
        // Get filtered cards
        $recentCards = Card::with(['user', 'cardType', 'mainCategory', 'subCategory'])
            ->ofType($cardTypeId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get main categories, subcategories and card types for filtering
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $designers = User::where('user_type', 'designer')->get();
        $languages = Card::getLanguageOptions();
        
        return view('cards.index', compact(
            'recentCards',
            'totalCards',
            'activeCards',
            'inactiveCards',
            'cardsByType',
            'mostUsedCards',
            'mainCategories',
            'cardTypes',
            'designers',
            'languages'
        ))->with('filter', __('Showing cards of type: :type', ['type' => $cardType->name]));
    }
    
    /**
     * Filter cards by main category.
     *
     * @param  int  $mainCategoryId
     * @return \Illuminate\Http\Response
     */
    public function filterByMainCategory($mainCategoryId)
    {
        $mainCategory = Category::findOrFail($mainCategoryId);
        
        // Get statistics for dashboard
        $totalCards = Card::count();
        $activeCards = Card::active()->count();
        $inactiveCards = Card::inactive()->count();
        
        // Get cards by type statistics
        $cardsByType = CardType::withCount('cards')->get();
        
        // Get most used cards
        $mostUsedCards = Card::orderBy('usage_count', 'desc')->take(5)->get();
        
        // Get filtered cards
        $recentCards = Card::with(['user', 'cardType', 'mainCategory', 'subCategory'])
            ->mainCategory($mainCategoryId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get main categories, subcategories and card types for filtering
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $designers = User::where('user_type', 'designer')->get();
        $languages = Card::getLanguageOptions();
        
        return view('cards.index', compact(
            'recentCards',
            'totalCards',
            'activeCards',
            'inactiveCards',
            'cardsByType',
            'mostUsedCards',
            'mainCategories',
            'cardTypes',
            'designers',
            'languages'
        ))->with('filter', __('Showing cards in category: :category', ['category' => $mainCategory->name]));
    }
    
    /**
     * Filter cards by sub category.
     *
     * @param  int  $subCategoryId
     * @return \Illuminate\Http\Response
     */
    public function filterBySubCategory($subCategoryId)
    {
        $subCategory = Category::findOrFail($subCategoryId);
        
        // Get statistics for dashboard
        $totalCards = Card::count();
        $activeCards = Card::active()->count();
        $inactiveCards = Card::inactive()->count();
        
        // Get cards by type statistics
        $cardsByType = CardType::withCount('cards')->get();
        
        // Get most used cards
        $mostUsedCards = Card::orderBy('usage_count', 'desc')->take(5)->get();
        
        // Get filtered cards
        $recentCards = Card::with(['user', 'cardType', 'mainCategory', 'subCategory'])
            ->subCategory($subCategoryId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get main categories, subcategories and card types for filtering
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $designers = User::where('user_type', 'designer')->get();
        $languages = Card::getLanguageOptions();
        
        return view('cards.index', compact(
            'recentCards',
            'totalCards',
            'activeCards',
            'inactiveCards',
            'cardsByType',
            'mostUsedCards',
            'mainCategories',
            'cardTypes',
            'designers',
            'languages'
        ))->with('filter', __('Showing cards in subcategory: :category', ['category' => $subCategory->name]));
    }
    
    /**
     * Filter cards by designer.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function filterByDesigner($userId)
    {
        $designer = User::findOrFail($userId);
        
        // Get statistics for dashboard
        $totalCards = Card::count();
        $activeCards = Card::active()->count();
        $inactiveCards = Card::inactive()->count();
        
        // Get cards by type statistics
        $cardsByType = CardType::withCount('cards')->get();
        
        // Get most used cards
        $mostUsedCards = Card::orderBy('usage_count', 'desc')->take(5)->get();
        
        // Get filtered cards
        $recentCards = Card::with(['user', 'cardType', 'mainCategory', 'subCategory'])
            ->designer($userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get main categories, subcategories and card types for filtering
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $designers = User::where('user_type', 'designer')->get();
        $languages = Card::getLanguageOptions();
        
        return view('cards.index', compact(
            'recentCards',
            'totalCards',
            'activeCards',
            'inactiveCards',
            'cardsByType',
            'mostUsedCards',
            'mainCategories',
            'cardTypes',
            'designers',
            'languages'
        ))->with('filter', __('Showing cards by designer: :name', ['name' => $designer->name]));
    }
    
    /**
     * Filter cards by language.
     *
     * @param  string  $language
     * @return \Illuminate\Http\Response
     */
    public function filterByLanguage($language)
    {
        $languages = Card::getLanguageOptions();
        
        if (!array_key_exists($language, $languages)) {
            return redirect()->route('cards.index')
                ->with('error', __('Invalid language specified.'));
        }
        
        // Get statistics for dashboard
        $totalCards = Card::count();
        $activeCards = Card::active()->count();
        $inactiveCards = Card::inactive()->count();
        
        // Get cards by type statistics
        $cardsByType = CardType::withCount('cards')->get();
        
        // Get most used cards
        $mostUsedCards = Card::orderBy('usage_count', 'desc')->take(5)->get();
        
        // Get filtered cards
        $recentCards = Card::with(['user', 'cardType', 'mainCategory', 'subCategory'])
            ->language($language)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Get main categories, subcategories and card types for filtering
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $designers = User::where('user_type', 'designer')->get();
        
        return view('cards.index', compact(
            'recentCards',
            'totalCards',
            'activeCards',
            'inactiveCards',
            'cardsByType',
            'mostUsedCards',
            'mainCategories',
            'cardTypes',
            'designers',
            'languages'
        ))->with('filter', __('Showing cards in language: :language', ['language' => $languages[$language]]));
    }
    
    /**
     * Filter cards by status.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function filterByStatus($status)
    {
        if (!in_array($status, ['active', 'inactive'])) {
            return redirect()->route('cards.index')
                ->with('error', __('Invalid status specified.'));
        }
        
        // Get statistics for dashboard
        $totalCards = Card::count();
        $activeCards = Card::active()->count();
        $inactiveCards = Card::inactive()->count();
        
        // Get cards by type statistics
        $cardsByType = CardType::withCount('cards')->get();
        
        // Get most used cards
        $mostUsedCards = Card::orderBy('usage_count', 'desc')->take(5)->get();
        
        // Get filtered cards
        if ($status === 'active') {
            $recentCards = Card::with(['user', 'cardType', 'mainCategory', 'subCategory'])
                ->active()
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            $filterLabel = __('Showing active cards');
        } else {
            $recentCards = Card::with(['user', 'cardType', 'mainCategory', 'subCategory'])
                ->inactive()
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            $filterLabel = __('Showing inactive cards');
        }
            
        // Get main categories, subcategories and card types for filtering
        $mainCategories = Category::where('is_main', true)->where('is_active', true)->get();
        $cardTypes = CardType::where('is_active', true)->get();
        $designers = User::where('user_type', 'designer')->get();
        $languages = Card::getLanguageOptions();
        
        return view('cards.index', compact(
            'recentCards',
            'totalCards',
            'activeCards',
            'inactiveCards',
            'cardsByType',
            'mostUsedCards',
            'mainCategories',
            'cardTypes',
            'designers',
            'languages'
        ))->with('filter', $filterLabel);
    }
    
    /**
     * Get subcategories for a main category.
     *
     * @param  int  $mainCategoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSubcategories($mainCategoryId)
    {
        $subcategories = Category::where('parent_id', $mainCategoryId)
            ->where('is_active', true)
            ->get(['id', 'name_en', 'name_ar']);
            
        return response()->json($subcategories);
    }
}