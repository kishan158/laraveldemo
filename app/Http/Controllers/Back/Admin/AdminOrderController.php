<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Vendor;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Avalibality;
use App\Models\VendorOrder;
use App\Events\NewOrderCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Add this line for logging
use App\Jobs\CheckOrderStatusJob;


class AdminOrderController extends Controller
{
    public function Order(Request $request)
    {
        $admin = Auth::guard('admin')->user();
    
        // Get search input from the request
        $search = $request->input('search');
    
        // Build the query to fetch orders
        $query = Order::with('customer')
              ->where('status', '!=', 3)  // Exclude orders with status 3
              ->orderBy('id', 'desc');
    
        // Apply search filter if an order_id is provided
        if ($search) {
            $query->where('order_id', 'like', '%' . $search . '%');
        }
    
        // Get the results, with pagination
        $data = $query->get();
    
        $categories = Category::all();

        // Filter vendors based on selected category
        $vendors = Vendor::where('category_id', $request->input('category_id'))
        ->whereHas('availability', function ($query) {
            $query->where('date', Carbon::today())
                  ->where('status', 1);
        })
        ->get();
        // dd($vendors);
        
       
    
        return view('back.admin.order.index', compact('data', 'vendors', 'categories', 'admin', 'search'));
    }
    public function checkAvailability(Request $request)
  {
    $vendorId = $request->input('vendor_id');
    $today = now()->toDateString(); // Current date in 'Y-m-d' format

    // Check if the vendor is available today
    $availability = Avalibality::where('vendor_id', $vendorId)
        ->where('date', $today)
        ->exists();

    if ($availability) {
        return response()->json(['status' => 'available', 'message' => 'Partner Available']);
    } else {
        return response()->json(['status' => 'not_available', 'message' => 'Partner Not Available']);
    }
 }

    public function deleteOrder($id)
{
    // Find the order by ID
    $order = Order::findOrFail($id);

    // Delete the order
    $order->delete();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Order deleted successfully');
}

public function TransferVendorOrder(Request $request)
{
    // Validate incoming request
    $request->validate([
        'selected_orders' => 'required',
        'vendor_id' => 'required',
    ], [
        'vendor_id.required' => 'Please select Vendor',
    ]);

    // Log the incoming request
    Log::info('Incoming request data: ', $request->all());

    // Decode selected orders
    $selectedOrders = json_decode($request->input('selected_orders'), true);

    // Log selected orders for debugging
    Log::info('Selected Orders: ', $selectedOrders);

    if (!$selectedOrders || count($selectedOrders) === 0) {
        return redirect()->back()->with('error', 'No orders selected for transfer.');
    }

    // Get the vendor ID
    $vendorId = $request->vendor_id;
    Log::info('Vendor ID: ', [$vendorId]);

    // Calculate vendor's total balance
    $totalCredit = Wallet::where('vendor_id', $vendorId)->sum('credit');
    $totalDebit = Wallet::where('vendor_id', $vendorId)->sum('debit');
    $totalBalance = $totalCredit - $totalDebit;

    // Log the balance for debugging
    Log::info('Total Balance: ', [$totalBalance]);

    if ($totalBalance < 6) {
        return redirect()->back()->with('error', 'Partner does not have enough balance. Minimum balance required is ₹60.');
    }

    // Process the selected orders
    foreach ($selectedOrders as $orderData) {
        $order = Order::where('order_id', $orderData['order_id'])->first();

        if ($order) {
            // Update order status
            $order->Order_status = 'Transferred';
            $order->save();
            Log::info('Order updated: ' . $order->order_id);

            // Create VendorOrder
            $vendorOrder = VendorOrder::create([
                'order_id' => $order->order_id,
                'customer_id' => $orderData['customer_id'],
                'vendor_id' => $vendorId,
                'notify_status'=>0,
            ]);
            Log::info('Vendor Order created: ' . $vendorOrder->id);

            // Create Wallet entry
            Wallet::create([
                'vendor_id' => $vendorId,
                'order_id' => $order->order_id,
                'debit' => 6.00, // Deduct ₹6 as required
            ]);
            Log::info('Wallet entry created for order: ' . $order->order_id);

            // Dispatch the job
            CheckOrderStatusJob::dispatch($order, $vendorOrder)->delay(now()->addMinute());
            Log::info('Job dispatched for order: ' . $order->order_id);
        }
    }

    return redirect()->back()->with('success', 'Orders transferred successfully.');
}



public function OrderHistory(Request $request)
{
    $admin = Auth::guard('admin')->user();

    // Get the search input from the request
    $search = $request->input('search');

    // Build the query to fetch orders where status is 3
    $query = Order::with('customer')->where('status', 3)->orderBy('id', 'desc');

    // Apply the search filter if order_id is provided
    if ($search) {
        $query->where('order_id', 'like', '%' . $search . '%');
    }

    // Get the orders with pagination
    $data = $query->paginate(10);

    return view('back.admin.order.orderhistory', compact('data', 'search'));
}




public function OrderRemove()
{
    // Get current time minus one minute
    $timeLimit = Carbon::now()->subMinute();

    // Fetch VendorOrders with status 0 created more than a minute ago
    $vendorOrders = VendorOrder::where('status', 0)
                    ->where('created_at', '<', $timeLimit)
                    ->get();

    foreach ($vendorOrders as $vendorOrder) {
        $vendorOrderId = $vendorOrder->order_id;

        // Delete the VendorOrder entry
        $vendorOrder->delete();

        // Find the matching order in the Order model by order_id
        $order = Order::where('order_id', $vendorOrderId)->first();

        if ($order) {
            // Update the order's status and order_status
            $order->update([
                'status' => 'Pending',
                'order_status' => 'Awaiting'
            ]);
        }
    }

    return "Old Vendor Orders removed and associated Orders updated.";
}
    
}

