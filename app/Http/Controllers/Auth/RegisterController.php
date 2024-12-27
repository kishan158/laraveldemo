<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function submit(Request $request)
{
    // Validate the input data
    $validator = Validator::make($request->all(), [
        'name' => 'required|alpha',
        'last_name' => 'nullable|alpha',
        'email' => 'required|email|unique:vendors,email',
        'address' => 'required',
        'phone' => 'required|unique:users,phone',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required',
    ]);

    // If validation fails, return back with errors
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Create a new User instance and fill it with the validated data
    $data = new Vendor();
    $data->name = $request->input('name');
    $data->last_name = $request->input('last_name');
    $data->email = $request->input('email');
    $data->phone = $request->input('phone');
    $data->address = $request->input('address');
    $data->password = Hash::make($request->input('password'));
    $data->notify_status = 0;
    // Save the user
    $data->save();

    // Return success message
    return redirect()->back()->with('success', 'Registration Successful');
}

}
