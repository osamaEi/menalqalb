<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users with dashboard statistics and filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get statistics for dashboard, including soft-deleted users
        $totalUsers = User::withTrashed()->count();
        $activeUsers = User::active()->count();
        $inactiveUsers = User::inactive()->count() + User::blocked()->count();
        $privilegedUsers = User::privilegedUser()->count();
        
        // Start with a base query including all users (with trashed)
        $query = User::withTrashed();
        
        // Apply filters from query parameters
        if ($request->has('user_type') && !empty($request->user_type)) {
            $query->where('user_type', $request->user_type);
            $filter = __("Showing only :type users", ['type' => str_replace('_', ' ', $request->user_type)]);
        }
        
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status === 'deleted') {
                $query->onlyTrashed();
            } else {
                $query->where('status', $request->status)->whereNull('deleted_at');
            }
            $filter = __("Showing only :status users", ['status' => $request->status]);
        }
        
        if ($request->has('country_id') && !empty($request->country_id)) {
            $query->where('country_id', $request->country_id);
            $country = Country::find($request->country_id);
            $filter = __("Showing only users from :country", ['country' => $country ? $country->name : '']);
        }
        
        $users = $query->paginate(10);
        $countries = Country::all();
        
        return view('users.index', compact(
            'users', 
            'countries', 
            'totalUsers', 
            'activeUsers', 
            'inactiveUsers', 
            'privilegedUsers'
        ))->with('filter', $filter ?? __('All Users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $userTypes = ['admin', 'privileged_user', 'regular_user', 'designer', 'sales_point'];
        $statuses = ['active', 'inactive', 'blocked', 'deleted'];
        
        return view('users.create', compact('countries', 'userTypes', 'statuses'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'country_id' => 'required|exists:countries,id',
            'whatsapp' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:20',
            'user_type' => 'required|in:admin,privileged_user,regular_user,designer,sales_point',
            'status' => 'required|in:active,inactive,blocked,deleted',
            'email_verified' => 'boolean',
            'whatsapp_verified' => 'boolean',
        ]);
        
        // Set default values for verified fields if not provided
        $validated['email_verified'] = $request->has('email_verified') ? $request->email_verified : false;
        $validated['whatsapp_verified'] = $request->has('whatsapp_verified') ? $request->whatsapp_verified : false;
        
        // Hash the password
        $validated['password'] = Hash::make($validated['password']);
        
        $user = User::create($validated);
        
        return redirect()->route('users.index')
            ->with('success', __('User created successfully.'));
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('cards', 'readyCards');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $countries = Country::all();
        $userTypes = ['admin', 'privileged_user', 'regular_user', 'designer', 'sales_point'];
        $statuses = ['active', 'inactive', 'blocked', 'deleted'];
        
        return view('users.edit', compact('user', 'countries', 'userTypes', 'statuses'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'country_id' => 'required|exists:countries,id',
            'whatsapp' => 'nullable|string|max:20',
            'user_type' => 'required|in:admin,privileged_user,regular_user,designer,sales_point',
            'status' => 'required|in:active,inactive,blocked,deleted',
            'email_verified' => 'boolean',
            'whatsapp_verified' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        // Update password only if provided
        if (!$request->filled('password')) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }
        
        // Set boolean values correctly
        $validated['email_verified'] = $request->has('email_verified') ? (bool)$request->email_verified : false;
        $validated['whatsapp_verified'] = $request->has('whatsapp_verified') ? (bool)$request->whatsapp_verified : false;
        
        $user->update($validated);
        
        return redirect()->route('users.index')
            ->with('success', __('User updated successfully.'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft delete the user
        
        return redirect()->route('users.index')
            ->with('success', __('User soft deleted successfully.'));
    }

    /**
     * Restore a soft-deleted user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        
        return redirect()->route('users.index')
            ->with('success', __('User restored successfully.'));
    }

    /**
     * Filter users by type.
     *
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function filterByType($type)
    {
        $validTypes = ['admin', 'privileged_user', 'regular_user', 'designer', 'sales_point'];
        
        if (!in_array($type, $validTypes)) {
            return redirect()->route('users.index')
                ->with('error', __('Invalid user type specified.'));
        }
        
        // Get statistics for dashboard
        $totalUsers = User::withTrashed()->count();
        $activeUsers = User::active()->count();
        $inactiveUsers = User::inactive()->count() + User::blocked()->count();
        $privilegedUsers = User::privilegedUser()->count();
        
        $users = User::with('country')->where('user_type', $type)->paginate(10);
        $countries = Country::all();
        
        return view('users.dashboard', compact(
            'users', 
            'countries', 
            'totalUsers', 
            'activeUsers', 
            'inactiveUsers', 
            'privilegedUsers'
        ))->with('filter', __("Showing only :type users", ['type' => str_replace('_', ' ', $type)]));
    }

    /**
     * Filter users by status.
     *
     * @param  string  $status
     * @return \Illuminate\Http\Response
     */
    public function filterByStatus($status)
    {
        $validStatuses = ['active', 'inactive', 'blocked', 'deleted'];
        
        if (!in_array($status, $validStatuses)) {
            return redirect()->route('users.index')
                ->with('error', __('Invalid status specified.'));
        }
        
        // Get statistics for dashboard
        $totalUsers = User::withTrashed()->count();
        $activeUsers = User::active()->count();
        $inactiveUsers = User::inactive()->count() + User::blocked()->count();
        $privilegedUsers = User::privilegedUser()->count();
        
        $query = User::with('country');
        if ($status === 'deleted') {
            $query->onlyTrashed();
        } else {
            $query->where('status', $status)->whereNull('deleted_at');
        }
        
        $users = $query->paginate(10);
        $countries = Country::all();
        
        return view('users.dashboard', compact(
            'users', 
            'countries', 
            'totalUsers', 
            'activeUsers', 
            'inactiveUsers', 
            'privilegedUsers'
        ))->with('filter', __("Showing only :status users", ['status' => $status]));
    }

    /**
     * Filter users by country.
     *
     * @param  int  $countryId
     * @return \Illuminate\Http\Response
     */
    public function filterByCountry($countryId)
    {
        $country = Country::find($countryId);
        
        if (!$country) {
            return redirect()->route('users.index')
                ->with('error', __('Invalid country specified.'));
        }
        
        // Get statistics for dashboard
        $totalUsers = User::withTrashed()->count();
        $activeUsers = User::active()->count();
        $inactiveUsers = User::inactive()->count() + User::blocked()->count();
        $privilegedUsers = User::privilegedUser()->count();
        
        $users = User::with('country')->where('country_id', $countryId)->paginate(10);
        $countries = Country::all();
        
        return view('users.dashboard', compact(
            'users', 
            'countries', 
            'totalUsers', 
            'activeUsers', 
            'inactiveUsers', 
            'privilegedUsers'
        ))->with('filter', __("Showing only users from :country", ['country' => $country->name]));
    }

    /**
     * Get User model.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($id)
    {
        $user = User::with('country')->find($id);
        
        if (!$user) {
            return response()->json(['error' => __('User not found')], 404);
        }
        
        return response()->json($user);
    }

    /** 
     * Toggle user active status.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(User $user)
    {
        if ($user->status === 'active') {
            $user->update(['status' => 'inactive']);
            $message = __('User has been deactivated.');
        } else {
            $user->update(['status' => 'active']);
            $message = __('User has been activated.');
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Block a user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function blockUser(User $user)
    {
        $user->update(['status' => 'blocked']);
        
        return redirect()->back()->with('success', __('User has been blocked.'));
    }

    /**
     * Verify user email.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Verify user WhatsApp.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
   

    public function verifyEmail(User $user)
{
    $user->update(['email_verified' => true]);

    return redirect()->back()->with('success', __('Email has been verified successfully.'));
}

public function verifyWhatsapp(User $user)
{
    $user->update(['whatsapp_verified' => true]);

    return redirect()->back()->with('success', __('WhatsApp number has been verified successfully.'));
}

}