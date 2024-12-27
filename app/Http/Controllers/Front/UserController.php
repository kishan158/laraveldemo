<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Mime\Email;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\Notification;
use App\Events\NewOrderCreated;
use App\Models\OrderOpt;
use App\Mail\OrderOtpMail;

class UserController extends Controller
{
    public function UserRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha',  
            'email' => 'required|unique:customers,email',
            'phone' => 'required|numeric',  
            'address' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); 
        }
    
        $data = new Customer();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->pin_code = $request->pin_code;
        $data->save();
    
        return redirect()->back()->with('success', 'User Registered Successfully');
    }



    public function logout()
{
    Session::forget('email');
    Session::forget('otp');
    return redirect()->back()->with('success', 'Logged out successfully.');
}
    
public function Dashboard()
{
    if (Session::has('email')) {
        $customer = Customer::where('email', Session::get('email'))->first();

        return view('front.dashboard', compact('customer'));
    }

    return redirect()->route('front.checkout')->with('error', 'Please log in to access the dashboard.');
}


public function order(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('front.user.login')->with('error', 'Please log in first.');
    }

    $customer = Auth::user();

    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|numeric|digits:10',
        'house_flat_number' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'pin_code' => 'required|numeric|digits:6',
        'landmark' => 'nullable|string|max:255',
        'date' => 'required|date',
        'time' => 'required',
    ]);

    // Update or create user information
    $customer->update([
        'name' => $request->input('name'),
        'phone' => $request->input('phone'),
        'role'=>'user',
    ]);

    // Validate cart
    $cart = session('cart');
    if (empty($cart)) {
        return redirect()->route('front.package')->with('error', 'Your cart is empty!');
    }

    // Calculate the grand total
    $grandTotal = array_reduce($cart, function ($total, $item) {
        return $total + ($item['quantity'] * $item['price']);
    }, 0);

    // Function to generate unique order ID
    function generateUniqueOrderId()
    {
        do {
            $orderId = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);
        } while (Order::where('order_id', $orderId)->exists());

        return $orderId;
    }

    // Generate unique order ID
    $orderId = generateUniqueOrderId();

    // Generate address string
    $address = implode(', ', array_filter([
        $request->input('house_flat_number'),
        $request->input('city'),
        $request->input('pin_code'),
        $request->input('landmark'),
    ]));

    // Create order data
    $orderData = [
        'order_id' => $orderId,
        'customer_id' => $customer->id,
        'total_price' => $grandTotal,
        'cart' => json_encode($cart),
        'date' => $request->input('date'),
        'time' => $request->input('time'),
        'address' => $address,
        'notify_status' => 0,
    ];

    // Create a new order
    $order = Order::create($orderData);

    // Generate a 6-digit OTP
    $otp = rand(100000, 999999);

    // Save OTP in the OrderOtp model
    OrderOpt::create([
        'user_id' => $customer->id,
        'order_id' => $orderId,
        'otp' => $otp,
    ]);

    // Send OTP to user's email
    Mail::to($customer->email)->send(new OrderOtpMail($otp));

    // Clear cart after order placement
    session()->forget('cart');

    return redirect()->route('front.home')->with('success', 'Order placed successfully! OTP has been sent to your email.');
}


}

