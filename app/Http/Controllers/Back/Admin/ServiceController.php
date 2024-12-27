<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\Models\Package;
use App\Models\ServiceTitle;
use App\Models\SubService;
class ServiceController extends Controller
{

    public function list()
    {
        $services = Service::orderBy('id', 'desc')->paginate(10);
        return view('back.admin.service.list', compact('services'));
    }
    public function add()
    {
        return view('back.admin.service.add');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service' => 'required|regex:/^[A-Za-z\s&]+$/',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
          
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = new Service();
        $data->service = $request->input('service');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('front/image'), $filename);
            $data->image = $filename; // Save the filename in the database
        }
        $data->save();
        return redirect()->route('admin.service.list')->with('success', 'Service Added');
    }

    public function serviceEdit($id)
    {
            $data = Service::findOrFail($id);
            return view('back.admin.service.edit',[
                'data'=>$data,
            ]);
    }
        
    public function serviceUpdate(Request $request, $id)
    {
            // Validate inputs
            $request->validate([
                'service' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            $data = Service::findOrFail($id);
            $data->service = $request->service;

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                if ($data->image && file_exists(public_path('front/image/' . $data->image))) {
                    unlink(public_path('front/image/' . $data->image));
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('front/image'), $filename);
                $data->image = $filename; 
            }

            $data->save();

            return redirect()->route('admin.service.list')->with('success', 'Service updated successfully');
    }

    public function serviceDelete($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image && file_exists(public_path('front/image/' . $service->image))) {
            unlink(public_path('front/image/' . $service->image));
        }

        $service->delete(); 

        return redirect()->route('admin.service.list')->with('success', 'Service deleted successfully.');
    }


    public function Titlelist($id)
    {
        $service = Service::find($id);
        $data = ServiceTitle::with('service')->where('service_id', $id)->orderBy('id', 'desc')->get();
        return view('back.admin.service_title.list',compact('data','service'));
    }

    public function Titleadd($id)
    {
        $service = Service::find($id);
        return view('back.admin.service_title.add',compact('service'));
    }
  
    public function TitleSubmit(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id', // Validate service_id
            'service_title' => 'required|regex:/^[A-Za-z\s&]+$/',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Save data
        $data = new ServiceTitle();
        $data->service_id = $request->service_id;
        $data->service_title = $request->service_title;
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('front/image'), $filename);
            $data->image = $filename;
        }
    
        $data->save();
    
        return redirect()->route('admin.service.title.list',['id'=>$id])->with('success', 'Title Added Successfully!');
    }

    public function TitleEdit($id)
    {
        $data = ServiceTitle::findOrFail($id);
        $service = Service::findOrFail($data->service_id);
        return view('back.admin.service_title.edit',compact('data','service'));
    }
    
    public function TitleUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id', // Validate service_id to ensure it exists in the services table
            'service_title' => 'required|regex:/^[A-Za-z\s&]+$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Image should be nullable for updates
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $data = ServiceTitle::find($id); // Retrieve the existing record
        if (!$data) {
            return redirect()->route('admin.service.title.list')->with('error', 'Service Title not found!');
        }
    
        $data->service_id = $request->service_id;
        $data->service_title = $request->service_title;
    
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('front/image'), $filename);
    
            // Delete the old image if it exists
            if ($data->image && file_exists(public_path('front/image/' . $data->image))) {
                unlink(public_path('front/image/' . $data->image));
            }
    
            $data->image = $filename;
        }
    
        $data->save();
    
        return redirect()->route('admin.service.title.list',['id'=>$request->service_id])->with('success', 'Title Updated Successfully!');
    }
    

    public function TitleDelete($id)
    {
        $data = ServiceTitle::findOrFail($id);

        if ($data->image && file_exists(public_path('front/image/' . $data->image))) {
            unlink(public_path('front/image/' . $data->image));
        }
    
        $data->delete(); 
    
        return redirect()->back()->with('success', 'Title deleted successfully.');
    }

    public function IssueList($id)
{
    // Find the service by its ID
    $service = Service::find($id);

    if (!$service) {
        return redirect()->back()->with('error', 'Service not found.');
    }

    // Fetch the first service title associated with the service ID
    $service_title = ServiceTitle::where('service_id', $service->id)->first();

    // Fetch the packages associated with the service ID
    $package = Package::where('service_id', $id)->orderBy('id', 'desc')->paginate(10);

    // Pass the data to the view
    return view('back.admin.package.list', compact('service', 'package', 'service_title'));
}

        public function issueAdd($id)
    {
        
        $service = Service::findOrFail($id);
        $service_titles = ServiceTitle::where('service_id', $service->id)->get(); // Fetch related service titles
        $selected_service_title_id = $service->service_title_id ?? null; 
   

        
        if (!$service) {
            return abort(404, 'Service not found');
        }

      
        return view('back.admin.package.add', compact('service','service_titles', 'selected_service_title_id'));
    }

    public function issueSubmit(Request $request, $id)
    {
       
        $request->validate([
           
            'package' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'required|numeric',
            'city' => 'required|string|max:255',
            'time_duration'=>'required',
            'warranty'=>'required',
           
            'pincode' => 'required|string|max:10',
        ]);
 
        // Create and save the new package
        $package = new Package();
        $package->service_id = $id;
        $package->service_title_id = $request->service_title_id;
        $package->package = $request->package;
        $package->price = $request->price;
        $package->previous_price = $request->previous_price;
        $package->convenience_fee = $request->convenience_fee;
        $package->visiting_charge = $request->visiting_charge;
        $package->time_duration = $request->time_duration;
        $package->warranty = $request->warranty;
        $package->discount = $request->discount;
        $package->city = $request->city;
        $package->pincode = $request->pincode;
        $package->description = $request->description;
        if ($request->hasFile('image')) {
         $file = $request->file('image');
         $filename = time() . '_' . $file->getClientOriginalName();
         $file->move(public_path('front/image'), $filename);
         $package->image = $filename; // Save the filename in the database
     }
       

        $package->save();
 
        // Redirect back with a success message
        return redirect()->route('admin.issue.list', ['id' => $id])->with('success', 'Package added successfully.');
    }

    public function issueEdit($id)
    {
        $package = Package::findOrFail($id); 
        $service = Service::findOrFail($package->service_id);
        $service_titles = ServiceTitle::where('service_id', $service->id)->get(); // Fetch related service titles
        $selected_service_title_id = $service->service_title_id ?? null; 
       
        return view('back.admin.package.edit', [
            'package' => $package,
            'service' => $service,
            'service_titles'=>$service_titles,
            'selected_service_title_id'=>$selected_service_title_id,
            
        ]);
    }


    public function issueUpdate(Request $request,$id)
    {
        $package = Package::findOrFail($id);

        // Update basic fields
        $package->service_id = $request->service_id;
        $package->service_title_id = $request->service_title_id;
        $package->package = $request->package;
        $package->price = $request->price;
        $package->previous_price = $request->previous_price;
        $package->convenience_fee = $request->convenience_fee;
        $package->visiting_charge = $request->visiting_charge;
        $package->time_duration = $request->time_duration;
        $package->warranty = $request->warranty;
        $package->city = $request->city;
        $package->pincode = $request->pincode;
        $package->description = $request->description;
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image && file_exists(public_path('front/image/' . $package->image))) {
                unlink(public_path('front/image/' . $package->image));
            }
    
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('front/image'), $filename);
            $package->image = $filename;
        }
    // dd($package);
        $package->save();
    
        return redirect()->route('admin.issue.list', ['id' => $request->service_id])->with('success', 'Package updated successfully.');
    }

    public function issueDelete($id)
    {
        $service = Package::findOrFail($id);

        if ($service->image && file_exists(public_path('front/image/' . $service->image))) {
            unlink(public_path('front/image/' . $service->image));
        }
    
        $service->delete(); 
    
        return redirect()->back()->with('success', 'Issue deleted successfully.');
    }
   

}

