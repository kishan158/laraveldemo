<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invite;
use App\Models\ReferEarn;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email;
use App\Models\HomeCustomize;
class AuthController extends Controller
{

    public function Register($invite_code = null)
    {
        $Images = HomeCustomize::first();
   
        $title = $Images ? json_decode($Images->title, true) : null;
        return view('front.register',compact('title','invite_code'));
    }
    public function UserRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|unique:users,email',
             'phone' => 'required|numeric|digits_between:10,15|unique:users,phone,',

            'address' => 'required',
            'city' => 'required',
            'pin_code' => 'required|numeric|digits:6',
            'invite_code' => 'nullable|string|exists:invites,invite_code',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'pin_code' => $request->pin_code,
            'role' => 'user',
        ]);
    
        // Generate unique invite code
        $uniqueCode = $this->generateUniqueInviteCode();
    
        // Save invite details
        $referrerId = null;
        if ($request->has('invite_code')) {
            $referrer = Invite::where('invite_code', $request->invite_code)->first();
            $referrerId = $referrer->user_id ?? null;
        }
    
        Invite::create([
            'user_id' => $user->id,
            'invite_code' => $uniqueCode,
            'referrer_id' => $referrerId,
        ]);
    
        return redirect()->back()->with('success', 'User Registered Successfully');
    }
    
  
  
    
    private function generateUniqueInviteCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Invite::where('invite_code', $code)->exists());
    
        return $code;
    }

    public function user_Login()
    {
        $Images = HomeCustomize::first();
   
        $title = $Images ? json_decode($Images->title, true) : null;
        return view('front.login',compact('title'));
    }
    
    public function UserLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    session(['email' => $request->email]);
    // Check if the user exists or create a new user
    $user = User::firstOrCreate(
        ['email' => $request->email],
        ['name' => 'Guest User']
    );

    // Generate OTP
    $otp = rand(100000, 999999);

    OTP::create([
        'user_id' => $user->id,
        'otp' => $otp,
        'expires_at' => Carbon::now()->addMinutes(10),
    ]);

    // Check if the user is newly created
    if ($user->wasRecentlyCreated) {
        // Generate unique invite code
        $uniqueCode = $this->generateUniqueInviteCode();

        // Save invite details
        Invite::create([
            'user_id' => $user->id,
            'invite_code' => $uniqueCode,
            'referrer_id' => null, // No referrer during first login
        ]);
    }

    try {
        // Send OTP email
        Mail::raw("Your OTP code is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Your OTP Code');
        });

        // Store the `redirect` parameter in session, or fallback to home
        $redirectUrl = $request->input('redirect', route('front.home'));
        session(['previous_url' => $redirectUrl]);

        return redirect()->back()->with('otp_sent', 'OTP sent to your email.');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to send OTP: ' . $e->getMessage());
    }
}
    
public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|numeric|digits:6',
    ]);

    $otpRecord = OTP::where('otp', $request->otp)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

    if ($otpRecord) {
        $user = $otpRecord->user;
        auth()->login($user);

        // Clear OTP after successful login
        $otpRecord->delete();

        // Redirect to the stored URL or fallback to home
        $previousUrl = session('previous_url', route('front.home'));
        
        session()->forget('previous_url');

        return redirect($previousUrl)->with('success', 'Login Successful');
    }

    return back()->with('error', 'Invalid OTP or session expired');
}

public function cleanExpiredOtps()
{
    OTP::where('expires_at', '<', Carbon::now())
        ->delete(); // Delete expired OTP records
}
public function logout()
{    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();

  
    return redirect()->route('front.home')->with('success', 'Logged out successfully.');
}
}
