<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the countries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new country.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Store a newly created country in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:countries',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $country = new Country();
        $country->name_ar = $request->name_ar;
        $country->name_en = $request->name_en;
        $country->code = $request->code;
        
        if ($request->hasFile('flag')) {
            $flagFile = $request->file('flag');
            $filename = time() . '.' . $flagFile->getClientOriginalExtension();
            $flagFile->storeAs('public/flags', $filename);
            $country->flag = 'flags/' . $filename;
        }
        
        $country->save();

        return redirect()->route('countries.index')
            ->with('success', __('Country created successfully.'));
    }

    /**
     * Display the specified country.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified country.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified country in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:countries,code,' . $country->id,
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $country->name_ar = $request->name_ar;
        $country->name_en = $request->name_en;
        $country->code = $request->code;
        
        if ($request->hasFile('flag')) {
            // Delete old flag if exists
            if ($country->flag) {
                \Storage::delete('public/' . $country->flag);
            }
            
            $flagFile = $request->file('flag');
            $filename = time() . '.' . $flagFile->getClientOriginalExtension();
            $flagFile->storeAs('public/flags', $filename);
            $country->flag = 'flags/' . $filename;
        }
        
        $country->save();

        return redirect()->route('countries.index')
            ->with('success', __('Country updated successfully.'));
    }

    /**
     * Remove the specified country from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        // Delete flag file if exists
        if ($country->flag) {
            \Storage::delete('public/' . $country->flag);
        }
        
        $country->delete();

        return redirect()->route('countries.index')
            ->with('success', __('Country deleted successfully.'));
    }
}