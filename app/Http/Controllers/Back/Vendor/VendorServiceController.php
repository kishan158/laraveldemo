<?php

namespace App\Http\Controllers\Back\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Package;
use App\Models\VendorService;
use App\Models\VendorOrder;
use App\Models\Order;
use App\Models\Bills;
use App\Models\OrderOpt;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\ReferEarn;
use App\Models\Invite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class VendorServiceController extends Controller
{
    public function vendorService()
    {
        $data = VendorService::where('status', 1)
                         ->orderBy('id', 'desc')
                         ->paginate(10);

      return view('back.vendor.service.list', compact('data'));
    }

    public function vendorServiceAdd()
    {
        $services = Service::with(['packages' => function($query) {
            $query->where('status', 1);
        }])->where('status', 1)->get();

        return view('back.vendor.service.add',compact('services'));
    }

    public function vendorServiceSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'package_id' => 'required|exists:packages,id',
            'price' => 'required|numeric',
            'city' => 'required|string|max:255',
            'time_duration'=>'required',
            'title'=>'required',
            'pincode' => 'required|string|max:10',
          
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new VendorService();
        $data->service_id = $request->service_id;
        $data->package_id = $request->package_id;
        $data->title = $request->title;
        $data->price = $request->price;
        $data->previous_price = $request->previous_price;
        $data->time_duration = $request->time_duration;
        $data->discount = $request->discount;
        $data->city = $request->city;
        $data->pincode = $request->pincode;
        $data->description = $request->description;
        $data->save();
        return redirect()->route('vendor.service.list')->with('success', 'Service Added');

    }
    public function vendorOrder()
    {
        $user = Auth::guard('vendor')->user();
    
        $orders = VendorOrder::where('vendor_id', $user->id)
            ->whereIn('status', [0, 1])
            ->with(['order.customer']) // Load order and customer relationships
            ->orderBy('id', 'desc')
            ->paginate(10);
       
        foreach ($orders as $order) {
            // Check if the order exists before accessing 'cart'
            if ($order->order) {
                $cart = json_decode($order->order->cart, true);
    
                if (is_array($cart) && !empty($cart)) {
                    $firstItem = reset($cart); // Get the first item from the cart
                    $serviceId = $firstItem['package_id'] ?? null;
    
                    if ($serviceId) {
                        $service = \App\Models\Service::find($serviceId); // Fetch the service details
                        $order->service = $service; // Attach the service details to the order
                    } else {
                        $order->service = null; // No service found
                    }
                } else {
                    $order->service = null; // Empty cart
                }
            } else {
                $order->service = null; // No associated order
            }
        }
    
        return view('back.vendor.order.list', compact('orders'));
    }
    
    public function vendorOrderShow($id)
    {
        $order = VendorOrder::with('order.customer') 
            ->where('id', $id)  
            ->first();  
  
        $products = Product::all();

        // dd($product);
        if (!$order) {
            return redirect()->route('vendor.service.order') // Redirect to the orders list if order not found
                ->with('error', 'Order not found');
        }

        // dd($order);
        $vendorOrder = VendorOrder::with('order.customer')->where('id', $id)->first();
    
        if (!$vendorOrder) {
            return redirect()->back()->with('error', 'Order not found.');
        }
  
        $orderId = $vendorOrder->order_id;
        $userId = $vendorOrder->order->customer->id;  
        $vendorId = auth()->guard('vendor')->id();  
       
        $bills = Bills::where('order_id', $orderId)
        ->where('user_id', $userId)
        ->where('vendor_id', $vendorId)
        ->get();
    
    foreach ($bills as $bill) {
        if ($bill->bill) {
            $inspectionData = json_decode($bill->bill, true);
    
            // Keep inspection data as-is
            $bill->inspection_data = $inspectionData;
        } else {
            $bill->inspection_data = [];
        }
    }
                    // dd($bills);
                    $reviste = Bills::where('order_id', $orderId)
                    ->where('user_id', $userId)
                    ->where('vendor_id', $vendorId)
                    ->get();
    //   dd($reviste);
                    foreach ($reviste as $bill) {
                        if ($bill->revisite) {
                            $bill->inspection_data = json_decode($bill->revisite, true); // Decode and assign revisite data
                        } else {
                            $bill->inspection_data = null;
                        }
                    }
   
        // Pass the order data to the view
        return view('back.vendor.order.show', compact('order','bills','reviste','products'));
    }
   

  
  
    public function updateStatus(Request $request, $id)
    {
        $user = Auth::guard('vendor')->user();
    
        if ($user) {
            $vendorOrder = VendorOrder::find($id);
            if (!$vendorOrder) {
                return redirect()->back()->with('success', 'Vendor Order not found!');
            }
    
            $status = $request->input('status');
            if (!in_array($status, [1, 2, 3])) {
                return redirect()->back()->with('success', 'Invalid status value!');
            }
    
            $vendorOrder->status = $status;
            $vendorOrder->save();
    
            $order = Order::where('order_id', $vendorOrder->order_id)->first();
            if ($order) {
                $order->status = $status;
    
                if ($status == 3) {
                    $cartData = json_decode($order->cart, true);
    
                    if (isset($cartData) && isset($cartData['2']['warranty'])) {
                        $warrantyValue = (int)$cartData['2']['warranty'];
                        $bill = Bills::where('order_id', $order->order_id)->first();
    
                        if ($bill) {
                            if ($bill->warranty === null) {
                                $bill->warranty = $warrantyValue;
                                $bill->date = Carbon::now();
                                $bill->warranty_expire = Carbon::now()->addMonths($warrantyValue);
                                $bill->save();
                            }
                        }
                    }
    
                    // Trigger reward distribution
                    $invite = Invite::where('user_id', $order->customer_id)->first();
                    if ($invite && $invite->referrer_id) {
                        $this->distributeReward($invite->referrer_id, $order->customer_id);
                    }
                }
    
                $order->save();
            }
    
            return redirect()->back()->with('success', 'Status updated successfully!');
        }
    
        return redirect()->back()->with('success', 'Unauthorized access');
    }
    

    private function distributeReward($referrerId, $newUserId)
{
    $rewardLevels = [
        1 => 50, // Level 1 reward
        2 => 15, // Level 2 reward
        3 => 15, // Level 3 reward
        4 => 10, // Level 4 reward
        5 => 10, // Level 5 reward
    ];

    $currentLevel = 1;

    while ($referrerId && isset($rewardLevels[$currentLevel])) {
        ReferEarn::create([
            'user_id' => $referrerId,
            'referrer_id' => $newUserId,
            'credit' => $rewardLevels[$currentLevel],
            'debit' => 0,
        ]);

        $referrer = Invite::where('user_id', $referrerId)->first();
        $referrerId = $referrer->referrer_id ?? null;

        $currentLevel++;
    }
}

    
    public function updateWorkStatus(Request $request, $id)
{
    $user = Auth::guard('vendor')->user(); // Get authenticated vendor

    if ($user) {
        $vendorOrder = VendorOrder::find($id);

        if (!$vendorOrder) {
            return redirect()->back()->with('error', 'Vendor Order not found!');
        }

        // Validate the input
        $request->validate([
            'work_status' => 'required|in:0,1,2',
        ]);

        // Update the work_status
        $vendorOrder->work_status = $request->input('work_status');
        $vendorOrder->save();
        
        $order = Order::where('order_id', $vendorOrder->order_id)->first();
        if ($order) {
            $order->work_status = $request->input('work_status');
            $order->save();
        }
        
        return redirect()->back()->with('success', 'Work status updated successfully!');
    }

    return redirect()->route('vendor.login')->with('error', 'Unauthorized access');
}

    
    

    public function vendorOrderAdd($id)
    {
        $order = VendorOrder::with('order.customer') 
        ->where('id', $id)  
        ->first();  

        return view('back.vendor.order.add', compact('order'));
    }
    public function vendorOrderSubmit(Request $request, $id)
    {
        // Fetch the order by its ID
        $order = VendorOrder::with('order.customer')->where('id', $id)->first();
    
        // Check if the order exists
        if (!$order) {
            return redirect()->route('vendor.service.order') // Redirect to the orders list if order not found
                ->with('error', 'Order not found');
        }
    
        // Update the order with the new data
        $order->extra_work = $request->extra_work;
        $order->price_added = $request->price_added;
    
        // Save the changes to the order
        $order->save();
    
        // Redirect back with a success message
        return redirect()->route('vendor.service.order')
            ->with('success', 'Order updated successfully');
    }

    public function generateInvoice($id)
    {
        $order = VendorOrder::with('order.customer')->findOrFail($id);
    
        $cart = json_decode($order->order->cart, true);
    
        $pdf = Pdf::loadView('back.vendor.order.invoice_pdf', compact('order', 'cart'));
    
        // Download the PDF file
        return $pdf->stream('order-invoice.pdf');
    }
    
    public function user_otp($id)
{
    // Fetch the order along with the customer data
    $order = VendorOrder::with('order.customer')->where('id', $id)->first();

    // Check if the order exists
    if (!$order) {
        return redirect()->route('vendor.service.order')
            ->with('error', 'Order not found');
    }

    // Get customer ID and Order ID
    $customerId = $order->order->customer->id;
    $orderID = $order->order->order_id;

    // Fetch the latest OTP record for this customer and order
    $orderOpt = OrderOpt::where('user_id', $customerId)
                        ->where('order_id', $orderID) // Ensure OTP is for the specific order
                        ->latest()
                        ->first();
    
    // Check if the OTP exists and if its status is 'verified'
    if ($orderOpt && $orderOpt->status === 'verified') {
        // If OTP is verified, redirect to the order show page
        return redirect()->route('vendor.service.order.show', ['id' => $id])
                         ->with('success', 'OTP already verified. Proceeding to inspection.');
    }

    // If OTP is not verified or does not exist, show OTP verification page
    return view('back.vendor.order.otpverify', compact('order'));
}


    public function user_otp_submit(Request $request, $id)
    {
        // Fetch the order along with the customer data
        $order = VendorOrder::with('order.customer')->where('id', $id)->first();
        
        // Check if the order exists
        if (!$order) {
            return redirect()->route('vendor.service.order')
                ->with('error', 'Order not found');
        }
    
        // Get customer ID and Order ID
        $customerId = $order->order->customer->id;
        $orderID = $order->order->order_id;
        
        // Validate OTP input
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);
    
        // Fetch the latest OTP record for this customer and order
        $orderOpt = OrderOpt::where('user_id', $customerId)
                            ->where('order_id', $orderID) // Ensure OTP is for the specific order
                            ->latest()
                            ->first();
        
        // Check if an OTP exists for the customer and order
        if (!$orderOpt) {
            return back()->with('error', 'No OTP found for this customer and order.');
        }
    
        // Check if the OTP matches
        if ($orderOpt->otp != $request->otp) {
            return back()->with('error', 'Invalid OTP. Please try again.');
        }
    
        
        $orderOpt->update(['status' => 'verified']);
    
        
        // Redirect with success message
        return redirect()->route('vendor.service.order.show', ['id' => $id])
            ->with('success', 'OTP verified successfully. Proceeding to inspection.');
    }
    

    

    public function inspection($id)
    {  
        $order = VendorOrder::with('order.customer')->where('id', $id)->first();
        return view('back.vendor.order.inspection',compact('order'));
    }

    public function inspectionSubmit(Request $request, $id)
    {
        $vendorOrder = VendorOrder::with('order.customer')->where('id', $id)->first();
    
        if (!$vendorOrder) {
            return redirect()->back()->with('error', 'Order not found.');
        }
    
        // Extract order_id and customer_id
        $orderId = $vendorOrder->order_id;
        $customerId = $vendorOrder->order->customer->id;
    
        // Prepare the inspection data from the request
        $items = $request->input('items');
        $values = $request->input('values');
    
        // Validation to ensure both arrays are present and equal in length
        if (!$items || !$values || count($items) !== count($values)) {
            return redirect()->back()->with('error', 'Invalid input data. Ensure all rows have both item and value.');
        }
    
        // Include Convenience Fee and Visiting Charge
        $convenienceFee = $request->input('convenience_fee');
        $visitingCharge = $request->input('visiting_charge');
    
        if ($convenienceFee !== null) {
            $items[] = 'Convenience Fee';
            $values[] = $convenienceFee;
        }
    
        if ($visitingCharge !== null) {
            $items[] = 'Visiting Charge';
            $values[] = $visitingCharge;
        }
    
        // Prepare the data to save
        $inspectionData = [];
        foreach ($items as $index => $item) {
            $inspectionData[] = [
                'item' => $item,
                'value' => $values[$index],
            ];
        }
    
        // Extract price data from the cart field and calculate Labour Cost
        $cartData = json_decode($vendorOrder->order->cart, true);
        $totalLabourCost = 0;
    
        if ($cartData) {
            foreach ($cartData as $item) {
                $totalLabourCost += $item['price']; // Summing up all prices in the cart
            }
        }
    
        // Add Labour Cost to inspection data
        $inspectionData[] = [
            'item' => 'Labour Cost',
            'value' => $totalLabourCost,
        ];
    
        // Determine the field to save based on revisite_status
        $fieldToSave = $vendorOrder->revisite_status == 1 ? 'revisite' : 'bill';
    // dd($fieldToSave);
        // Save the data in the appropriate field
        Bills::updateOrCreate(
            [
                'order_id' => $orderId,
                'user_id' => $customerId,
                'vendor_id' => auth()->guard('vendor')->id(),
            ],
            [
                $fieldToSave => json_encode($inspectionData), // Save in either 'revisite' or 'bill'
                'status' => '0',
            ]
        );
    
        return redirect()->back()->with('success', 'Inspection data submitted successfully!');
    }
    
    
    
    
    public function inspectionBill($id)
    {
        $vendorOrder = VendorOrder::with('order.customer')->where('id', $id)->first();
   
        if (!$vendorOrder) {
            return redirect()->back()->with('error', 'Order not found.');
        }
  
        $orderId = $vendorOrder->order_id;
        $userId = $vendorOrder->order->customer->id;  
        $vendorId = auth()->guard('vendor')->id();  
       
        $bills = Bills::where('order_id', $orderId)
                      ->where('user_id', $userId)
                      ->where('vendor_id', $vendorId)
                      ->get();  
                     
                      foreach ($bills as $bill) {
                        if ($bill->bill) {
                            $inspectionData = json_decode($bill->bill, true); 
                            $bill->inspection_data = $inspectionData; 
                        } else {
                            $bill->inspection_data = null;
                        }
                    }
                
                      
               
                 
        return view('back.vendor.order.show', compact('bills'));
    }
    public function updateBill($id)
    {
        // Fetch the Bill based on the ID
        $bill = Bills::find($id);
    
        if (!$bill) {
            return redirect()->back()->with('error', 'Bill not found.');
        }
    
        // Update the 'sent' field to 1 (assuming 0 means not sent and 1 means sent)
        $bill->sent = 1;
        $bill->status = 1;
    
        // Save the changes
        $bill->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Estimate Sent to Customer.');
    }

    public function updateRevisiteBill($id)
    {
        $bill = Bills::find($id);
    
        if (!$bill) {
            return redirect()->back()->with('error', 'Bill not found.');
        }
    
        // Update the 'sent' field to 1 (assuming 0 means not sent and 1 means sent)
        $bill->revisite_sent = 1;
        $bill->revisite_sent_status = 1;
    
        // Save the changes
        $bill->save();
        return redirect()->back()->with('success', 'Estimate Sent to Customer.');
    }

    public function OrderHistory()
    {
        $user = Auth::guard('vendor')->user();
        // Use `get()` to fetch all matching records
      
     
        $orders = VendorOrder::where('vendor_id', $user->id)
        ->whereIn('status', [3]) // Checks if status is either 3 or 1
        ->orderBy('id', 'desc')
        ->paginate(10);
        // foreach ($orders as $bill) {
        //     if ($bill->bill) {
        //         $inspectionData = json_decode($bill->bill, true); 
        //         $bill->inspection_data = $inspectionData;
        //     } else {
        //         $bill->inspection_data = null;
        //     }
        // }
        // dd($orders);
        return view('back.vendor.order.orderhistory',compact('orders'));
    }
  
    public function storeInvoice(Request $request, $id)
  {
    $bill = Bills::findOrFail($id);

    // Decode the incoming invoice data
    $invoiceData = json_decode($request->invoice_data, true);
    

    // Save the invoice data to the 'invoice' field
    $bill->invoice = $invoiceData;
    $bill->save();

    return redirect()->back()->with('success', 'Invoice data saved successfully!');
  }

  public function Vendor_orderhistory_show($order_id)
  {

    $order = Order::where('order_id', $order_id)->first();
    if (!$order) {
        return redirect()->back()->with('error', 'Order not found');
    }
    $data = Bills::where('order_id', $order_id)->first();
    $Redata = Bills::where('order_id', $order_id)->first();
    $Revisite = VendorOrder::where('order_id', $order_id)->first();

    if ($data && isset($data->bill)) {
        // Decode the 'bill' JSON data into an array
        $billData = json_decode($data->bill, true);
    } else {
        // Handle the case where the 'bill' data is not found
        $billData = [];
    }
    if ($Redata && isset($Redata->revisite)) {
        // Decode the 'bill' JSON data into an array
        $RebillData = json_decode($Redata->revisite, true);
    } else {
        // Handle the case where the 'bill' data is not found
        $RebillData = [];
    }
    $paymentData = $data && isset($data->payment) ? json_decode($data->payment, true) : [];
    $RepaymentData = $data && isset($data->revisite_payment) ? json_decode($data->revisite_payment, true) : [];
    $totalValue = 0;
    if (!empty($billData)) {
        foreach ($billData as $bill) {
            $totalValue += (float)$bill['value'];
        }
    }
    $RetotalValue = 0;
    if (!empty($RebillData)) {
        foreach ($RebillData as $Rebill) {
            $RetotalValue += (float)$Rebill['value'];
        }
    }
   
    $cartItems = json_decode($order->cart, true);
    // dd($cartItems);

    $totalPrice = 0;
    if (!empty($cartItems)) {
        foreach ($cartItems as $item) {
            $totalPrice += (float)$item['quantity'] * (float)$item['price'];
        }
    }

    return view('back.vendor.order.orderHistoryShow', compact('order','Revisite','RetotalValue','cartItems','billData','RebillData','data','totalPrice','RetotalValue','totalValue','paymentData','RepaymentData'));
  }

  public function vendorPayment(Request $request, $id)
  {
      // Validate the input data
      $request->validate([
          'payment_method' => 'required|string',
          'total_price' => 'required',
      ]);
  
      // Fetch the bill using the provided ID
      $bill = Bills::findOrFail($id);
  
      // Prepare payment data to save
      $paymentData = [
          'method' => $request->input('payment_method'),
          'total_price' => $request->input('total_price'),
      ];
  
      // Save the payment data in the 'payment' field
      $bill->payment = json_encode($paymentData); 
      $bill->save();
  
      return redirect()->back()->with('success', 'Payment Completed!');
  }

  public function RevendorPayment(Request $request, $id)
  {
      // Validate the input data
      $request->validate([
          'payment_method' => 'required|string',
          'total_price' => 'required',
      ]);
  
      // Fetch the bill using the provided ID
      $bill = Bills::findOrFail($id);
  
      // Prepare payment data to save
      $paymentData = [
          'method' => $request->input('payment_method'),
          'total_price' => $request->input('total_price'),
      ];
  
      // Save the payment data in the 'payment' field
      $bill->revisite_payment = json_encode($paymentData); 
      $bill->save();
  
      return redirect()->back()->with('success', 'Revisite Payment Completed!');
  }
  
  

}