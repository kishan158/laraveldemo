<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Finance;
use App\Models\SubCategory;
use App\Models\VendorOrder;
use App\Models\Order;
use App\Models\Bills;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function list(Request $request)
    {
        // Fetch search keyword from the request
        $search = $request->input('search');
    
        // Build the query
        $query = Vendor::where('role', 'vendor');
    
        // Apply search filter if a search term is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
    
        // Paginate results
        $vendor = $query->orderBy('id', 'desc')->paginate(10);
    
        // Pass search term back to the view
        return view('back.admin.vendor.list', compact('vendor', 'search'));
    }
    
    public function add()
    {
      return view('back.admin.vendor.add');
    }

    public function submit(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'name'      => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email'     => 'required|email|unique:vendors,email|max:255',
        'phone'     => 'required|digits:10|unique:vendors,phone',
        'password'  => 'required|min:6',
        'city'      => 'required',
        'pin_code'  => 'required|min:6',
        'address'   => 'required'
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
       }

      $vendors = new Vendor();
      $vendors->name = $request->name;
      $vendors->last_name = $request->last_name;
      $vendors->email = $request->email;
      $vendors->phone = $request->phone;
      $vendors->password = Hash::make($request->password);
      $vendors->city = $request->city;
      $vendors->pin_code = $request->pin_code;
      $vendors->address = $request->address; 
      if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('back/image'), $filename);
        $vendors->image = $filename; 
      }
      $vendors->save();

      return redirect()->route('admin.vendor.list')->with('success', 'Partner Added');
    }

    public function Updatestatus($id)
    {
        $vendor = Vendor::findOrFail($id);

        $vendor->status = $vendor->status == 1 ? 0 : 1;

        $vendor->save();

        return back()->with('success', 'Status updated successfully!');
    }

    public function VendorProfile($id)
    {
    $vendor = Finance::where('vendor_id', $id)->first();  
    $data = Vendor::where('id',$id)->first();

    if (!$vendor) {
        return redirect()->back()->with('error', 'Vendor not found');
    }
    $personalDetails = json_decode($vendor->personal_details, true);
    $bankDetails = json_decode($vendor->bank_details, true);
    $kycDetails = json_decode($vendor->gst_details, true);
    $kycDetails2 = json_decode($vendor->pan_card_details, true);
    $category = $data->category;  // Get the category by relationship
    $subcategories = Category::get(); // Fetch subcategories

    return view('back.admin.vendor.vendor_profile', compact('vendor', 'personalDetails','bankDetails','kycDetails','kycDetails2','data','category','subcategories'));
    }


    public function Vendor_cat($id)
    {
        $data = Vendor::where('id',$id)->first();
        if (!$data) {
        return redirect()->back()->with('error', 'Vendor not found');
    }
    $subcategories = Category::get();

    return view('back.admin.vendor.vendor_cat',compact('data','subcategories'));

    }

    public function Vendor_cat_submit(Request $request, $id)
    {
        $data = Vendor::where('id', $id)->first();
    
        if (!$data) {
            return redirect()->back()->with('error', 'Vendor not found');
        }
    
        $request->validate([
            'category_id' => 'required|exists:categories,id', 
            
        ]);
    
        
        $data->category_id = $request->category_id;  
    
        
    
        $data->save();
    
        return redirect()->route('admin.vendor.profile', $id)->with('success', 'Partner Category  updated successfully');
    }

    public function Vendor_order_history(Request $request, $id)
    {
        $data = Vendor::where('id', $id)->first();
    
        if (!$data) {
            return redirect()->back()->with('error', 'Vendor not found');
        }
    
        // Fetch search keyword from the request
        $search = $request->input('search');
    
        // Build the query
        $query = VendorOrder::where('vendor_id', $id)
                            ->whereIn('status', [1, 3])  // Filter by status
                            ->orderBy('id', 'desc');
    
        // Apply search filter if an order_id is provided
        if ($search) {
            $query->where('order_id', 'like', '%' . $search . '%');
        }
    
    
        $orders = $query->paginate(10);
    
        return view('back.admin.vendor.order_history', compact('orders', 'search','data'));
    }
  

    public function Vendor_orderhistory_show($order_id)
    {
        $Cartorder = Order::where('order_id', $order_id)->first();
        if (!$Cartorder) {
            return redirect()->back()->with('error', 'Order not found');
        }
        $order = VendorOrder::where('order_id', $order_id)->with(['vendor', 'customer'])->first(); 
        // dd($order);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found');
        }
        $data = Bills::where('order_id', $order_id)->first();

        // Check if $data exists and has the 'bill' field
        if ($data && isset($data->bill)) {
            // Decode the 'bill' JSON data into an array
            $billData = json_decode($data->bill, true);
        } else {
            // Handle the case where the 'bill' data is not found
            $billData = [];
        }

        if ($data && isset($data->bill)) {
            // Decode the 'bill' JSON data into an array
            $RebillData = json_decode($data->revisite, true);
        } else {
            // Handle the case where the 'bill' data is not found
            $RebillData = [];
        }

        $paymentData = $data && isset($data->payment) ? json_decode($data->payment, true) : [];
        $RepaymentData = $data && isset($data->revisite_payment) ? json_decode($data->revisite_payment, true) : [];

        // dd($paymentData);
        $totalValue = 0;
        if (!empty($billData)) {
            foreach ($billData as $bill) {
                $totalValue += (float)$bill['value'];
            }
        }
        if (!empty($RebillData)) {
            foreach ($RebillData as $bill) {
                $totalValue += (float)$bill['value'];
            }
        }
    
        $cartItems = json_decode($Cartorder->cart, true);

        $totalPrice = 0;
        if (!empty($cartItems)) {
            foreach ($cartItems as $item) {
                $totalPrice += (float)$item['quantity'] * (float)$item['price'];
            }
        }

        return view('back.admin.vendor.viewOrderHistory', compact('order','Cartorder','RebillData','RepaymentData','cartItems','billData','data','totalPrice','totalValue','paymentData'));
    }
}
