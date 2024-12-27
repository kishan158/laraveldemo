<?php

namespace App\Http\Controllers\Back\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    
    public function profile()
 {
    $vendor = Auth::guard('vendor')->user(); // Get the authenticated vendor

    // Check if the user is a vendor (assuming 'role' column exists)
    if ($vendor && $vendor->role === 'vendor') {
        return view('back.vendor.profile.profile', compact('vendor'));
    }

    // Redirect or show an error if the user is not a vendor
    return redirect()->route('vendor.login')->with('error', 'Unauthorized access');
 }

 public function profileUpdate(Request $request)
 {
     $vendor = Auth::guard('vendor')->user(); // Get the authenticated vendor
 
     $request->validate([
         'name' => 'required|string|max:255',
         'last_name' => 'required|string|max:255',
         'email' => 'required|email|unique:vendors,email,' . $vendor->id, // Update with vendor table
         'phone' => 'nullable|string|max:15',
         'city' => 'required|string|max:255',
         'pin_code' => 'required|string|max:255',
         'address' => 'required|string|max:255',
         'password' => 'nullable|min:6',
         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
     ]);
 
     $vendor->name = $request->input('name');
     $vendor->last_name = $request->input('last_name');
     $vendor->email = $request->input('email');
     $vendor->phone = $request->input('phone');
     $vendor->city = $request->input('city');
     $vendor->pin_code = $request->input('pin_code');
     $vendor->address = $request->input('address');
 
     if ($request->filled('password')) {
         $vendor->password = Hash::make($request->input('password'));
     }
 
     if ($request->hasFile('image')) {
         if ($vendor->image && Storage::exists($vendor->image)) {
             Storage::delete($vendor->image);
         }
 
         $vendor->image = $request->file('image')->store('profiles', 'public');
     }
 
     $vendor->save();
 
     return redirect()->back()->with('success', 'Profile updated successfully!');
 }
 
}
