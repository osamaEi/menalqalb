<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories with dashboard statistics.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categoryQuery = Category::query();
       
        // Apply filters
        if ($request->filled('type')) {
            if ($request->type == 'main') {
                $categoryQuery->main();
            } elseif ($request->type == 'sub') {
                $categoryQuery->subs(); // Now using the renamed scope
            }
        }
       
        if ($request->filled('parent_id')) {
            $categoryQuery->where('parent_id', $request->parent_id);
        }
       
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $categoryQuery->active();
            } elseif ($request->status == 'inactive') {
                $categoryQuery->inactive();
            }
        }
       
        // Count statistics
        $totalCategories = Category::count();
        $mainCategories = Category::main()->count();
        $subcategories = Category::subs()->count(); // Use the new scope name
        $activeCategories = Category::active()->count();
        $inactiveCategories = Category::inactive()->count();
       
        // Get filtered categories with pagination
        $categories = $categoryQuery->with('parent')->paginate(10)->withQueryString();
        $parentCategories = Category::getParentCategories();
       
        // Determine filter title
        $filter = __('All Categories');
        if ($request->filled('type')) {
            $filter = $request->type == 'main' ? __('Main Categories') : __('Subcategories');
        }
        if ($request->filled('parent_id')) {
            $parentName = Category::find($request->parent_id)->name ?? '';
            $filter = __('Subcategories of') . ' ' . $parentName;
        }
        if ($request->filled('status')) {
            $filter = $request->status == 'active' ? __('Active Categories') : __('Inactive Categories');
        }
       
        return view('categories.index', compact(
            'categories',
            'parentCategories',
            'totalCategories',
            'mainCategories',
            'subcategories',
            'activeCategories',
            'inactiveCategories',
            'filter'
        ));
    }
    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::getParentCategories();
        return view('categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_main' => 'boolean',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->boolean('is_main') && $value) {
                        $fail(__('Main categories cannot have a parent category.'));
                    }
                    if (!$request->boolean('is_main') && !$value) {
                        $fail(__('Subcategories must have a parent category.'));
                    }
                },
            ],
            'is_active' => 'boolean',
        ]);
        
        // Set default values
        $validated['is_main'] = $request->boolean('is_main', false);
        $validated['is_active'] = $request->boolean('is_active', true);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = $path;
        }
        
        $category = Category::create($validated);
        
        return redirect()->route('categories.index')
            ->with('success', __('Category created successfully.'));
    }

    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category->load('parent', 'subcategories');
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::getParentCategories()->where('id', '!=', $category->id);
        return view('categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_main' => 'boolean',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                Rule::prohibitedIf(function () use ($category, $request) {
                    // Cannot select itself as parent
                    return $category->id == $request->parent_id;
                }),
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->boolean('is_main') && $value) {
                        $fail(__('Main categories cannot have a parent category.'));
                    }
                    if (!$request->boolean('is_main') && !$value) {
                        $fail(__('Subcategories must have a parent category.'));
                    }
                },
            ],
            'is_active' => 'boolean',
        ]);
        
        // Set default values
        $validated['is_main'] = $request->boolean('is_main', false);
        $validated['is_active'] = $request->boolean('is_active', true);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            $path = $request->file('image')->store('categories', 'public');
            $validated['image'] = $path;
        }
        
        $category->update($validated);
        
        return redirect()->route('categories.index')
            ->with('success', __('Category updated successfully.'));
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Check if category has subcategories (children)
        if ($category->children()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', __('Cannot delete category with subcategories.'));
        }
       
        // Check if category has products
       
        // Delete image if exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
       
        $category->delete();
       
        return redirect()->route('categories.index')
            ->with('success', __('Category deleted successfully.'));
    }
    /**
     * Toggle category active status.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        
        $message = $category->is_active ? 
            __('Category has been activated.') : 
            __('Category has been deactivated.');
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Filter categories by type (main or subcategories).
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function filterByType($type)
    {
        if (!in_array($type, ['main', 'sub'])) {
            return redirect()->route('categories.index')
                ->with('error', __('Invalid category type specified.'));
        }
        
        // Get statistics for dashboard
        $totalCategories = Category::count();
        $mainCategories = Category::main()->count();
        $subcategories = Category::subcategories()->count();
        $activeCategories = Category::active()->count();
        $inactiveCategories = Category::inactive()->count();
        
        if ($type === 'main') {
            $categories = Category::main()->paginate(10);
            $filterLabel = __('Showing only main categories');
        } else {
            $categories = Category::subcategories()->paginate(10);
            $filterLabel = __('Showing only subcategories');
        }
        
        $parentCategories = Category::getParentCategories();
        
        return view('categories.dashboard', compact(
            'categories', 
            'parentCategories', 
            'totalCategories', 
            'mainCategories', 
            'subcategories', 
            'activeCategories',
            'inactiveCategories'
        ))->with('filter', $filterLabel);
    }
    
    /**
     * Filter categories by status (active or inactive).
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function filterByStatus($status)
    {
        if (!in_array($status, ['active', 'inactive'])) {
            return redirect()->route('categories.index')
                ->with('error', __('Invalid status specified.'));
        }
        
        // Get statistics for dashboard
        $totalCategories = Category::count();
        $mainCategories = Category::main()->count();
        $subcategories = Category::subcategories()->count();
        $activeCategories = Category::active()->count();
        $inactiveCategories = Category::inactive()->count();
        
        if ($status === 'active') {
            $categories = Category::active()->paginate(10);
            $filterLabel = __('Showing only active categories');
        } else {
            $categories = Category::inactive()->paginate(10);
            $filterLabel = __('Showing only inactive categories');
        }
        
        $parentCategories = Category::getParentCategories();
        
        return view('categories.dashboard', compact(
            'categories', 
            'parentCategories', 
            'totalCategories', 
            'mainCategories', 
            'subcategories', 
            'activeCategories',
            'inactiveCategories'
        ))->with('filter', $filterLabel);
    }
    
    /**
     * Filter categories by parent.
     *
     * @param  int  $parentId
     * @return \Illuminate\Http\Response
     */
    public function filterByParent($parentId)
    {
        $parent = Category::findOrFail($parentId);
        
        // Get statistics for dashboard
        $totalCategories = Category::count();
        $mainCategories = Category::main()->count();
        $subcategories = Category::subs()->count(); // Use the new scope name
        $activeCategories = Category::active()->count();
        $inactiveCategories = Category::inactive()->count();
        
        $categories = Category::where('parent_id', $parentId)->paginate(10);
        $parentCategories = Category::getParentCategories();
        
        return view('categories.index', compact(
            'categories', 
            'parentCategories', 
            'totalCategories', 
            'mainCategories', 
            'subcategories', 
            'activeCategories',
            'inactiveCategories'
        ))->with('filter', __('Showing subcategories of :category', ['category' => $parent->name]));
    }
}