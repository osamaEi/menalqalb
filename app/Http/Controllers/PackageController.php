<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(10);
        
        // Statistics
        $totalPackages = Package::count();
        $activePackages = Package::where('is_active', true)->count();
        $inactivePackages = Package::where('is_active', false)->count();
        
        return view('admin.packages.index', compact(
            'packages',
            'totalPackages',
            'activePackages',
            'inactivePackages'
        ));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Package::create($validated);

        return redirect()->route('packages.index')
            ->with('success', __('Package created successfully'));
    }

    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', __('Package updated successfully'));
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', __('Package deleted successfully'));
    }

    public function toggleStatus(Package $package)
    {
        $package->update(['is_active' => !$package->is_active]);

        return redirect()->route('packages.index')
            ->with('success', __('Status updated successfully'));
    }
}