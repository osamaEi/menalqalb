<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the settings.
     */
    public function index()
    {
        $settings = Settings::all();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new setting.
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created setting in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar'=>'nullable',
            'name_en'=>'nullable',
            'key' => 'required|string|max:255|unique:settings,key',
            'type' => 'required|in:text,image',
            'value' => 'required_if:type,text',
            'image' => 'required_if:type,image|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $setting = new Settings();
        $setting->key = $request->key;
        $setting->type = $request->type;

        if ($request->type === 'text') {
            $setting->value = $request->value;
        } else {
            // Handle image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('settings', $filename, 'public');
                $setting->value = $path;
            }
        }

        $setting->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully.');
    }

    /**
     * Show the form for editing the specified setting.
     */
    public function edit(Settings $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified setting in storage.
     */
    public function update(Request $request, Settings $setting)
    {
        $rules = [
            'key' => 'required|string|max:255|unique:settings,key,' . $setting->id,
            'type' => 'required|in:text,image',
        ];

        if ($request->type === 'text') {
            $rules['value'] = 'required';
        } elseif ($request->hasFile('image')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $setting->key = $request->key;
        $setting->type = $request->type;

        if ($request->type === 'text') {
            $setting->value = $request->value;
        } elseif ($request->hasFile('image')) {
            // Delete old image if exists
            if ($setting->type === 'image' && $setting->value && Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
            
            // Upload new image
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('settings', $filename, 'public');
            $setting->value = $path;
        }

        $setting->save();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting updated successfully.');
    }

    /**
     * Remove the specified setting from storage.
     */
    public function destroy(Settings $setting)
    {
        // Delete image if setting is an image
        if ($setting->type === 'image' && $setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }

        $setting->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting deleted successfully.');
    }
}