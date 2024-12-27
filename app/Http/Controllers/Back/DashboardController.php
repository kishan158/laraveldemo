<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\WidthrawRequest;
use Carbon\Carbon;
use App\Models\Avalibality;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
    
        $data = User::count(); 
        $order = Order::count(); 
        $notificationVendor = Order::where('notify_status', 0)->count();
        $notificationAdmin = Order::where('notify_status', 0)->count();
        $transferOrders = Order::where('Order_status', 'Transferred')->count();
        $newOrders = Order::where('status', 'Pending')->count();
        $completedOrders = Order::where('status', '3')->count();
        $totalVendors = Vendor::count();

        return view('back.admin.dashboard', compact('admin', 'data', 'order','completedOrders','newOrders','transferOrders','notificationAdmin','notificationVendor','totalVendors'));
    }

    public function markAsRead()
    {
        Order::where('notify_status', 0)->update(['notify_status' => 1]);
    
        return redirect()->route('admin.order')->with('success', 'All notifications marked as read.');
    }
    public function markAsReadVendor()
    {
        Vendor::where('notify_status', 0)->update(['notify_status' => 1]);
    
        return redirect()->route('admin.vendor.list')->with('success', 'All notifications marked as read.');
    }

    public function markAsReadVendorOrder()
    {
        VendorOrder::where('notify_status', 0)->update(['notify_status' => 1]);
    
        return redirect()->route('vendor.service.order')->with('success', 'All notifications marked as read.');
    }
    
    public function markAsWidthraw()
    {
        WidthrawRequest::where('notify_status', 0)->update(['notify_status' => 1]);
    
        return redirect()->route('admin.widthraw.request')->with('success', 'All notifications marked as read.');
    }
    public function vendor()
    {
       $vendor = Auth::guard('vendor')->user();

       $orderCount = VendorOrder::where('vendor_id', $vendor->id)->count();
       $orderPending = VendorOrder::where('vendor_id', $vendor->id)->where('status','0')->count();
       $orderComplete = VendorOrder::where('vendor_id', $vendor->id)->where('status',3)->count();
       $partnerAvailable = Avalibality::where('vendor_id', $vendor->id)
       ->whereDate('date', Carbon::today()) 
       ->first();
       $availability = Avalibality::where('vendor_id', $vendor->id)
       ->whereDate('date', Carbon::today())
       ->first();
       $notifyVendor = VendorOrder::where('notify_status', 0)->count();
       $availabilityStatus = $partnerAvailable ? 'Available' : 'Not Available';
       $currentStatus = $availability ? $availability->status : null;

       return view('back.vendor.dashboard', compact('vendor', 'orderCount','orderPending','orderComplete','partnerAvailable','availabilityStatus','currentStatus','notifyVendor'));
    }

    public function AvaliblitySubmit(Request $request)
    {
        // Get the currently logged-in vendor
        $vendor = Auth::guard('vendor')->user();
        
        // Validate that a valid date is selected
        $request->validate([
            'date' => 'required|date', // Ensure the date is in correct format
        ]);
    
        // Create a new availability record
        $data = new Avalibality();
        $data->vendor_id = $vendor->id;  // Get the vendor ID from the logged-in vendor
        $data->date = $request->date;    // Get the selected date
        $data->save();                   // Save the new record to the database
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Availability added successfully');
    }

    public function StatusSubmit(Request $request)
{
    $vendor = Auth::guard('vendor')->user();
    $request->validate([
        'status' => 'required|in:0,1',
    ]);

    
    // Get today's date
    $currentDate = now()->toDateString();
    
    // Check if there is an availability record for the current date
    $availability = Avalibality::where('date', $currentDate)->first();

    if (is_null($availability)) {
        return back()->with('error', 'First check your availability.');
    } else {
        // If availability record exists, update the status
        $availability->status = $request->status;
        $availability->save();

        // Return success message based on the status
        if ($request->status == 1) {
            return back()->with('success', 'You are now online.');
        } elseif ($request->status == 0) {
            return back()->with('success', 'You are now offline.');
        }
    }
}
public function getUnreadNotificationCount()
{
    $unreadCount = Auth::guard('admin')->user()->unreadNotifications->count();
    return response()->json(['unreadCount' => $unreadCount]);
}

    public function adminNotifications()
    {
        $notifications = Auth::user()->notifications; 
        return view('admin.notifications', compact('notifications')); 
    }
   

    public function markNotificationAsRead($id)
{
    $user = Auth::user();

    // Check if the user is a vendor
    if ($user && $user->role === 'vendor') {
        $notification = $user->notifications->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    return redirect()->route('vendor.notifications');
}

}
