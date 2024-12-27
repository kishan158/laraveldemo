<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QR;
use App\Models\WalletRecharge;
use App\Models\Vendor;
use App\Models\Wallet;
use App\Models\KYC;
use App\Models\User;
use App\Models\ReferEarn;
use App\Models\WidthrawRequest;

class RechargeController extends Controller
{
    public function QRCode()
    {
        $data = QR::all();
        // dd($data);
        return view('back.admin.QR_Code.list',compact('data'));
    }

    public function QRCodeAdd()
    {
        return view('back.admin.QR_Code.add');
    }

    public function QRCodeSubmit(Request $request)
    {
        $request->validate([
            'upi_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            
            'image.required' => 'Please upload an image.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be of type jpeg, png, jpg, gif, or svg.',
            'image.max' => 'The image size cannot exceed 2MB.',
        ]);

        $data = new QR();
        $data->upi_id = $request->upi_id;
        $data->image = $request->image->store('images', 'public');
        $data->save();
    
        // Redirect with a success message if validation passes
        return redirect()->route('admin.qr_code')->with('success', 'QR and UPI ID added successfully');
    }

    public function QRedit($id)
    {
        $data = QR::findOrFail($id);
        return view('back.admin.QR_Code.edit', compact('data'));
    }

    public function UpdateQRedit(Request $request, $id)
   {
    
    $request->validate([
        'upi_id' => 'required',
        'image' => 'nullable|image',
    ]);

    $qr = QR::findOrFail($id);
    
    $qr->upi_id = $request->upi_id;

    if ($request->hasFile('image')) {
        if ($qr->image) {
            Storage::disk('public')->delete($qr->image);
        }

        $qr->image = $request->image->store('qr_images', 'public');
    }

    $qr->save();

    return redirect()->route('admin.qr_code')->with('success', 'QR and UPI ID updated successfully.');
   }

   public function QRDelete($id)
   {
       $data = QR::findOrFail($id);
   
       // Optional: Delete the associated image if applicable
       if ($data->image && file_exists(public_path('path/to/images/' . $data->image))) {
           unlink(public_path('path/to/images/' . $data->image));
       }
   
       // Delete the QR record
       $data->delete();
   
       return redirect()->route('admin.qr_code')->with('success', 'QR code deleted successfully.');
   }



 public function Recharge()
 {
    $data = WalletRecharge::with('vendor')->orderBy('id', 'desc')->paginate(10);
    return view('back.admin.vendor.recharge_request',compact('data'));
 }
 public function RechargeupdateStatus(Request $request, $id)
 {
     
     $request->validate([
         'status' => 'required|in:pending,completed,failed',
     ]);
 
     $walletRecharge = WalletRecharge::findOrFail($id);
     
     if ($walletRecharge->status == 'completed') {
         return redirect()->back()->with('error', 'Wallet Already Recharged and cannot be changed.');
     }
 
     $walletRecharge->status = $request->status;
     $walletRecharge->save();
 
     if ($request->status == 'completed') {
         $vendor = Vendor::find($walletRecharge->vendor_id);
 
         if ($vendor) {
             $wallet = Wallet::where('vendor_id', $vendor->id)->first();
 
             $points = $walletRecharge->amount / 10;  // For every 10 rupees, 1 point is added
 
             if ($wallet) {
                 $wallet->credit +=  $points; 
                
                 $wallet->save();
             } else {
                 $wallet = new Wallet();
                 $wallet->vendor_id = $vendor->id;
                 $wallet->credit =  $points;
             
                 $wallet->save();
             }
         }
     }
 
     // Return success message
     return redirect()->back()->with('success', 'Status updated and wallet credited successfully.');
 }
 
    public function widthraw()
    {
        $data = WidthrawRequest::with(['user', 'kyc']) // Eager load user and kyc relationships
                           ->orderBy('id', 'desc')   // Order by id in descending order
                           ->paginate(10); 
        // dd($data);
        return view('back.admin.widthraw.index', compact('data'));
    }

    public function widthrawUpdate(Request $request, $id)
{
    $data = WidthrawRequest::findOrFail($id);
    
  

    // Toggle status
    $data->status = $data->status == 0 ? 1 : 0;

   

    // Save the updated status
    $data->save();



    $user_id = $data->user_id;
    $amount = $data->amount;

    $referEarn = new ReferEarn();
    $referEarn->user_id = $user_id;
    $referEarn->debit = $amount;
    $referEarn->save();

    return redirect()->back()->with('success', 'Status updated successfully');
}

 


}
