<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorOrder;
use App\Models\Bills;
use App\Models\User;
use App\Models\Order;
use App\Models\KYC;
use App\Models\Invite;
use App\Models\WidthrawRequest;
use App\Models\ReferEarn;
use App\Models\HomeCustomize;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserDashBoardController extends Controller
{
    public function index()
    {
        $Images = HomeCustomize::first();
     
        $title = $Images ? json_decode($Images->title, true) : null;
        return view('front.dashboard',compact('title'));
    }

    public function booking()
    {
        $user = Auth::user();
// dd($user);
    
        $Images = HomeCustomize::first();
     
        $title = $Images ? json_decode($Images->title, true) : null;
        if ($user && $user->role == 'user') {
    
            $userOrders =Order::where('customer_id', $user->id)
                ->where('status', '!=', 3) 
               
                ->orderBy('id', 'desc') 
                ->paginate(2); 
    
     
            // dd($userOrders);
            return view('front.booking.booking', compact('userOrders','title'));
        }
    
        return redirect()->route('front.home');
    }
    

    public function bill($id)
    {
        $user = Auth::user(); 
        $Images = HomeCustomize::first();
        
        $title = $Images ? json_decode($Images->title, true) : null;
        
        if ($user) {
            $vendorOrders = VendorOrder::where('order_id', $id)
                ->where('customer_id', $user->id)
                ->with('vendor')
                ->get();

                // dd($vendorOrders);
            // Retrieve bills from Bills model using the same order_id
            $userOrders = Bills::where('order_id', $id)
                ->where('user_id', $user->id)
                ->get();
        
            // Retrieve the order from Order model using order_id to get the total_price
            $order = Order::where('order_id', $id)->first();
            $orderTotalPrice = $order ? $order->total_price : 0; // Get the total_price from the Order model if it exists
    
            $invoiceData = [];
            $totalPrice = 0;
            $totalOrderPrice =0;
            foreach ($userOrders as $order) {
                if ($order->bill) {
                    // Decode the 'bill' field and dump the data for debugging
                    $invoiceData = json_decode($order->bill, true);
                    
                    if (isset($invoiceData['items'])) {
                        foreach ($invoiceData['items'] as $item) {
                            // Ensure the 'value' is numeric and add to the totalPrice
                            if (isset($item['value']) && is_numeric($item['value'])) {
                                $totalPrice += (float) $item['value'];
                            }
                        }
                    }
                }
            }

            $reviste = Bills::where('order_id', $id)
            ->where('user_id', $user->id)
            ->get();
            

            foreach ($reviste as $bill) {
            if ($bill->revisite) {
                $bill->inspection_data = json_decode($bill->revisite, true);
                
            } else {
            $bill->inspection_data = null;
            }
            }
                    
            // Return the view with the order's total price from the Order model
            return view('front.booking.bill', compact('userOrders','reviste','vendorOrders', 'totalPrice', 'title', 'invoiceData', 'orderTotalPrice','totalOrderPrice'));
        }
        
        return redirect()->route('front.home');
    }
    
    
    
    public function updateBillStatus(Request $request,$id)
  {
    $status = $request->input('status');
    $bill = Bills::find($id);

    if (!$bill) {
        return redirect()->back()->with('error', 'Bill not found.');
    }

    if ($bill->status == 2 || $bill->status == 3) {
        return redirect()->back()->with('error', 'This bill has already been processed.');
    }

    $bill->status = $status;
    $bill->save();

     return redirect()->back()->with('success', 'Status updated to rejected.');
  }

  public function updateBillStatusRevisite(Request $request, $id, $status)
  {
      // Find the bill by ID
      $bill = Bills::find($id);
      
      // Check if the bill exists
      if (!$bill) {
          return redirect()->back()->with('error', 'Bill not found.');
      }
  
      // Check if the bill has already been processed (accepted or rejected)
      if ($bill->revisite_sent_status == 2 || $bill->revisite_sent_status == 3) {
          return redirect()->back()->with('error', 'This bill has already been processed.');
      }
  
      // Update the revisite_sent_status with the provided status
      $bill->revisite_sent_status = $status;
      $bill->save();
  
      // Set the success message to reflect the updated status
      $statusMessage = $status == 3 ? 'rejected' : ($status == 2 ? 'accepted' : 'updated');
  
      return redirect()->back()->with('success', "Status updated to {$statusMessage}.");
  }
  
   public function orderHistory()
   {
    $user = Auth::user();
    
    $Images = HomeCustomize::first();
     
    $title = $Images ? json_decode($Images->title, true) : null;
    if ($user && $user->role == 'user') {

        $userOrders = VendorOrder::where('customer_id', $user->id)
            ->where('status', '!=', 0) 
            ->with('order.customer') 
            ->orderBy('id', 'desc') 
            ->paginate(3); 

  
        
        return view('front.booking.history', compact('userOrders','title'));
    }

     return redirect()->route('front.home');
  }

  public function Revisite(Request $request,$id)
  {
      $user = Auth::user();
  
      if ($user) {
          // Fetch vendor orders with vendor details
          $vendorOrders = VendorOrder::where('order_id', $id)
              ->where('customer_id', $user->id)
              ->with('vendor')
              ->get();
            //   dd($vendorOrders);
          foreach ($vendorOrders as $vendorOrder) {
            VendorOrder::create([
                  'vendor_id' => $vendorOrder->vendor_id,
                  'order_id' => $vendorOrder->order_id,
                  'customer_id' => $vendorOrder->customer_id,
                  'revisite_status'=>1,
                 
              ]);
          }
  
          return redirect()->back()->with('success', 'Revisite submitted successfully!');
      }
  
      return redirect()->back()->with('error', 'User not authenticated.');
  }
  

   public function UserProfile()
  {
    $user = Auth::user();
    $Images = HomeCustomize::first();
     
    $title = $Images ? json_decode($Images->title, true) : null;
    if ($user) {
        $data = User::where('role', 'user')->where('id', $user->id)->first(); 

        return view('front.booking.profile', compact('data','title'));
    }
    
    return redirect()->route('front.home');
 }

 public function UserProfileUpdate(Request $request)
{
    $user = Auth::user();
    
    if ($user) {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone,' . $user->id, // Unique check, excluding current user's phone
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, 
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:10',
        ]);

        // Update the user's data
        $user->update([
            'name' => $validatedData['name'],
            'last_name' => $validatedData['last_name'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'] ?? $user->address,
            'city' => $validatedData['city'] ?? $user->city,
            'pin_code' => $validatedData['pin_code'] ?? $user->pin_code,
        ]);

        // Redirect or return success message
        return redirect()->route('user.front.profile')->with('success', 'Profile updated successfully');
    }

    return redirect()->route('front.home');
}

 public function UserSetting()
 {
    $Images = HomeCustomize::first();
     
    $title = $Images ? json_decode($Images->title, true) : null;
    return view('front.booking.setting',compact('title'));
 }
 public function UserSettingPassword(Request $request)
 {
     $user = Auth::user();
 
     $request->validate([
         'new_password' => 'required|string|min:6|confirmed', 
     ], [
         'new_password.confirmed' => 'The password confirmation does not match.',
         'new_password.min' => 'The password must be at least 6 characters.',
     ]);
 
     $user->password = Hash::make($request->new_password); 
     $user->save();
 
     // Redirect back with success message
     return redirect()->route('user.front.setting')
                      ->with('success', 'Password updated successfully');
 }


 public function UserWallet()
 {
     $Images = HomeCustomize::first();
     $title = $Images ? json_decode($Images->title, true) : null;
 
     $user = Auth::user();
     $invite_code = Invite::where('user_id', $user->id)->first();

     $records = ReferEarn::where('user_id', $user->id)->paginate(2);
     $totals = ReferEarn::where('user_id', $user->id)
         ->selectRaw('SUM(credit) as total_credit, SUM(debit) as total_debit')
         ->first();
 
        //  dd($records);
     $totalCredit = $totals->total_credit ?? 0; 
     $totalDebit = $totals->total_debit ?? 0;
     $totalBalance = $totalCredit - $totalDebit;
 
     // Pass the data to the view
     return view('front.booking.wallet', compact('title','records', 'totalCredit','invite_code', 'totalDebit', 'totalBalance'));
 }

 public function WalletWidthdraw()
 {
    $Images = HomeCustomize::first();
    $title = $Images ? json_decode($Images->title, true) : null;
    $user = Auth::user();
    $data = KYC::where('user_id',$user->id)->first();
   
 
    $records = ReferEarn::where('user_id', $user->id)->paginate(2);
    $totals = ReferEarn::where('user_id', $user->id)
        ->selectRaw('SUM(credit) as total_credit, SUM(debit) as total_debit')
        ->first();

       //  dd($records);
    $totalCredit = $totals->total_credit ?? 0; 
    $totalDebit = $totals->total_debit ?? 0;
    $totalBalance = $totalCredit - $totalDebit;


    return view('front.booking.widthraw', compact('title', 'data','totalCredit', 'totalDebit', 'totalBalance'));
 }


 public function KYC_Submit(Request $request)
{
    $request->validate([
        'name' => 'required|alpha', // Alphabetic characters only
        'pan_no' => 'required|alpha_num|size:10|unique:k_y_c_s,pan_no,' . Auth::user()->id . ',user_id', // PAN unique to user
        'adhar_no' => 'required|digits:16|unique:k_y_c_s,adhar_no,' . Auth::user()->id . ',user_id', // Aadhaar unique to user
        'bank_name' => 'required',
        'account_no' => 'required|alpha_num|max:20|unique:k_y_c_s,account_no,' . Auth::user()->id . ',user_id', // Account unique to user
        'bank_branch' => 'required',
        'bank_ifsc' => 'required',
    ]);

    // Find existing KYC record for the user
    $data = KYC::where('user_id', Auth::user()->id)->first();

    if ($data) {
        // Update existing record
        $data->name = $request->name;
        $data->pan_no = $request->pan_no;
        $data->adhar_no = $request->adhar_no;
        $data->bank_name = $request->bank_name;
        $data->account_no = $request->account_no;
        $data->bank_branch = $request->bank_branch;
        $data->bank_ifsc = $request->bank_ifsc;
        $data->status = 1; // Update status to 1
        $data->save();

        // Redirect with an update success message
        return redirect()->back()->with('success', 'KYC Updated Successfully!');
    } else {
        // Create a new KYC record
        $data = new KYC();
        $data->user_id = Auth::user()->id;
        $data->name = $request->name;
        $data->pan_no = $request->pan_no;
        $data->adhar_no = $request->adhar_no;
        $data->bank_name = $request->bank_name;
        $data->account_no = $request->account_no;
        $data->bank_branch = $request->bank_branch;
        $data->bank_ifsc = $request->bank_ifsc;
        $data->status = 1; // Mark as active
        $data->save();

        // Redirect with a create success message
        return redirect()->back()->with('success', 'KYC Completed!');
    }
}


public function widthrawRequestSubmit(Request $request)
{
    $request->validate([
        'account_no' => 'required',
        'amount' => 'required|numeric|min:500', // Ensure minimum amount is 1000
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Calculate the user's total balance
    $totals = ReferEarn::where('user_id', $user->id)
        ->selectRaw('SUM(credit) as total_credit, SUM(debit) as total_debit')
        ->first();

    $totalCredit = $totals->total_credit ?? 0;
    $totalDebit = $totals->total_debit ?? 0;
    $totalBalance = $totalCredit - $totalDebit;

    // Check if the requested amount exceeds the available balance
    if ($request->amount > $totalBalance) {
        return redirect()->back()->with('error', 'Insufficient balance for withdrawal.');
    }

    // Save the withdrawal request
    $data = new WidthrawRequest();
    $data->user_id = $user->id;
    $data->account_no = $request->account_no;
    $data->amount = $request->amount;
    $data->save();

    return redirect()->back()->with('success', 'Withdrawal Request Submitted!');
}

public function WidthrawHistory()
{
    $Images = HomeCustomize::first();
    $title = $Images ? json_decode($Images->title, true) : null;

    // Fetch withdrawal requests with pagination
    $data = WidthrawRequest::with('user')->orderBy('id', 'desc')->paginate(3);
    // Pass the title and data to the view
    return view('front.booking.widthrawHistory', compact('title', 'data'));
}


 
 
}