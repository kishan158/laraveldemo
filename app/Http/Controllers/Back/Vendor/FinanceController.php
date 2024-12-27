<?php

namespace App\Http\Controllers\Back\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Finance;

class FinanceController extends Controller
{
    public function index()
    {
        $user = Auth::guard('vendor')->user();
    
        if ($user) {
            $financeData = Finance::where('vendor_id', $user->id)->first();
    
            // dd($financeData);
            return view('back.vendor.finance.index', compact('financeData'));
        }
    
        return redirect()->route('vendor.login');
    }

    public function financesaveOrUpdate(Request $request)
    {
        // Retrieve the logged-in vendor's ID
        $vendorId = Auth::guard('vendor')->user()->id;
    
        // Check the form type
        $formType = $request->input('form_type');
    
        // Conditional validation based on form type
        if ($formType === 'gst_form') {
            $request->validate([
                'gst_name' => 'required|string|max:255',
                'gst_no' => 'required|string|max:15',
            ]);
    
            $gstData = [
                'gst_name' => $request->gst_name,
                'gst_no' => $request->gst_no,
            ];
    
            Finance::updateOrCreate(
                ['vendor_id' => $vendorId],
                ['gst_details' => json_encode($gstData)]
            );
    
            return redirect()->back()->with('success', 'GST details saved successfully!');
        }
    
        if ($formType === 'pan_form') {
            $request->validate([
                'pan_name' => 'required|string|max:255',
                'pan_no' => 'required|string|max:10',
                'pan_upload' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            ]);
    
            $panCardData = [
                'pan_name' => $request->pan_name,
                'pan_no' => $request->pan_no,
            ];
    
            if ($request->hasFile('pan_upload')) {
                $panCardData['pan_upload'] = $request->file('pan_upload')->store('uploads/pan_cards', 'public');
            }
    
            Finance::updateOrCreate(
                ['vendor_id' => $vendorId],
                ['pan_card_details' => json_encode($panCardData)]
            );
    
            return redirect()->back()->with('success', 'Pan Card  saved successfully!');
        }
    
        if ($formType === 'bank_form') {
            $request->validate([
                'bank_name' => 'required|string|max:255',
                'account_name' => 'required|string|max:255',
                'account_number' => 'required|string|max:20',
                'branch' => 'required|string|max:255',
                'ifsc_code' => 'required|string|max:11',
            ]);
    
            $bankDetailsData = [
                'account_name' => $request->account_name,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'branch' => $request->branch,
                'ifsc_code' => $request->ifsc_code,
            ];
    
            Finance::updateOrCreate(
                ['vendor_id' => $vendorId],
                ['bank_details' => json_encode($bankDetailsData)]
            );
    
            return redirect()->back()->with('success', 'Bank details saved successfully!');
        }
    
        if ($formType === 'personal_form') {
            $request->validate([
                'name' => 'required|string|max:255',
                'aadhar_number' => 'required|string|max:12',
                'aadhar_upload' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
                'dob' => 'required|date',
                'father_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15',
                'gender' => 'required|string|max:10',
                'address' => 'required|string',
                'city' => 'required|string|max:255',
                'pin_code' => 'required|string|max:6',
            ]);
    
            $personalDetailsData = [
                'name' => $request->personal_name,
                'aadhar_number' => $request->aadhar_number,
                'dob' => $request->dob,
                'father_name' => $request->father_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'address' => $request->address,
                'city' => $request->city,
                'pin_code' => $request->pin_code,
            ];
    
            if ($request->hasFile('aadhar_upload')) {
                $personalDetailsData['aadhar_upload'] = $request->file('aadhar_upload')->store('uploads/aadhar_cards', 'public');
            }
    
            Finance::updateOrCreate(
                ['vendor_id' => $vendorId],
                ['personal_details' => json_encode($personalDetailsData)]
            );
    
            return redirect()->back()->with('success', 'Personal details saved successfully!');
        }
    
        return redirect()->back()->with('error', 'Invalid form type!');
    }
    
}
