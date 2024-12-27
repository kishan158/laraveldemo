<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Vendor;
class LoginController extends Controller
{
    public function login()
    {
       
        return view('auth.login');
    }
    public function loginSubmit(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        // Debugging - Check if the credentials are being passed correctly
        \Log::info("Attempting login for email: " . $request->email);
        
        if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password])) {
            \Log::info("Login successful for email: " . $request->email);
            $vendor = Auth::guard('vendor')->user();
    
            if ($vendor->role === 'vendor') {
                return redirect()->route('vendor.dashboard')->with('success', 'Welcome to the Vendor Dashboard');
            }
    
            Auth::guard('vendor')->logout();
            return back()->with('error', 'Access denied. Invalid user role.');
        }
    
        // Log if authentication failed
        \Log::error("Login failed for email: " . $request->email);
        
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->withInput(); 
    }
    

    public function adminLogin()
    {  
        return view('back.admin.auth.login');
    }

    public function adminSubmit(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        // Attempt to authenticate using the 'admin' guard
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Get the authenticated admin user
            $admin = Auth::guard('admin')->user();
    
            // Check if the authenticated user has the 'admin' role
            if ($admin->role === 'Admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome to the Admin Dashboard');
            }
    
            // Logout if the user does not have admin privileges
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'Access denied. You do not have admin privileges.');
        }
    
        // If authentication fails, return with an error message
        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->withInput();
    }
    
    
    public function logout()
{
    Auth::guard('vendor')->logout();

    session()->invalidate();

    session()->regenerateToken();

    return redirect()->route('vendor.login')->with('success', 'You have been logged out successfully.');
}

public function Adminlogout(Request $request)
{
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login')->with('success', 'You have been logged out successfully.');
}

   
}