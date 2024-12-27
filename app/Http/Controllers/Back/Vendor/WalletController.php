<?php

namespace App\Http\Controllers\Back\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
use App\Models\QR;
use App\Models\WalletRecharge;
class WalletController extends Controller
{
    public function walletBalance()
  {
    $user = Auth::guard('vendor')->user();
    
    if ($user) {
        // Fetch the wallet records for the authenticated vendor
        $data = Wallet::where('vendor_id', $user->id)->orderBy('id','desc')->paginate(10);
        $totalCredit = Wallet::where('vendor_id', $user->id)->sum('credit');
        $totalDebit = Wallet::where('vendor_id', $user->id)->sum('debit');

        // Calculate the balance (credit - debit)
        $balance = $totalCredit - $totalDebit;
        foreach ($data as $wallet) {
            echo $wallet->order_id; 
        }
    } else {
        return redirect()->route('vendor.login')->with('error', 'Please login first.');
    }

    return view('back.vendor.wallet.balance', compact('data','totalCredit','totalDebit','balance'));
  }

  public function RechargeWallet()
  {
    $data = QR::all();
    // dd($data);
    return view('back.vendor.wallet.recharge',compact('data'));
  }

  public function RechargeWalletSubmit(Request $request)
  {
      // Validate the incoming request
      $request->validate([
          'amount' => 'required|numeric',  
          'Utr_no' => 'required|string|unique:wallet_recharges,transaction_id',  // Ensure UTR number is unique in the wallet_recharges table
      ]);
      
      // Get the authenticated vendor
      $user = Auth::guard('vendor')->user();
      
      // Check if the transaction ID already exists in the database
      $existingTransaction = WalletRecharge::where('transaction_id', $request->Utr_no)->first();
      
      if ($existingTransaction) {
          // If the transaction ID already exists, return an error message
          return redirect()->route('vendor.wallet.rechargelist')->with('error', 'This UTR number has already been used for another transaction.');
      }
      
      // Create a new wallet recharge record
      $data = new WalletRecharge();
      $data->vendor_id = $user->id;  
      $data->amount = $request->amount;
      $data->transaction_id = $request->Utr_no; 
      $data->save();  
      
      // Redirect with success message
      return redirect()->route('vendor.wallet.rechargelist')->with('success', 'Wallet recharged successfully.');
  }
  

  public function RechargeWalletList()
  {
    $user = Auth::guard('vendor')->user();
    $data = WalletRecharge::where('vendor_id', $user->id)->orderBy('id','desc')->paginate(10);
    return view('back.vendor.wallet.list',compact('data'));
  }
}
