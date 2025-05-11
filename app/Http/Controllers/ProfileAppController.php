<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileAppController extends Controller
{
    /**
     * Show the profile edit form
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        $countries = Country::all();
        return view('app.profile.edit', compact('user', 'countries'));
    }

    /**
     * Update the user's profile information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'country_id' => ['required', 'exists:countries,id'],
            'whatsapp' => ['required', 'string', 'max:20'],
        ];
        
        // Add company_name validation only if user_type is sales_point
        // if ($request->user_type === 'sales_point') {
        //     $rules['company_name'] = ['required', 'string', 'max:255'];
        // }
        
        $validated = $request->validate($rules);
        
  
        
        $user->update($validated);
        
        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
    
    /**
     * Show the form for changing password
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('app.profile.change-password');
    }
    
    /**
     * Update the user's password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user = Auth::user();
        
        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }
        
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('profile.edit')->with('success', 'تم تحديث كلمة المرور بنجاح');
    }
}