<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeCustomize;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class HomeCustomizeController extends Controller
{
    public function index()
    {
        $data = HomeCustomize::first();
     
        $title = $data ? json_decode($data->title, true) : null;
        $banner1 = $data ? json_decode($data->banner1, true) : null;
        $banner2 = $data ? json_decode($data->banner2, true) : null;
        $banner3 = $data ? json_decode($data->banner3, true) : null;
        $mobile_view = $data ? json_decode($data->mobile_view, true) : null;
        // dd($mobile_view);
      
        return view('back.admin.home_page.index',compact('title', 'banner1', 'banner2', 'banner3','mobile_view'));
    }
    public function submit(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // For logo image validation
        ]);
    
        // Initialize the data array for title and address
        $data = [
            'title' => $request->input('title'),
            'address' => $request->input('address'),
        ];
    
        // Handle logo upload if available
        if ($request->hasFile('logo')) {
            // Store the logo without resizing
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }
    
        // Check if the data already exists (fetch the first record or null if none exists)
        $homeCustomize = HomeCustomize::first();
    
        if ($homeCustomize) {
            // If data exists, update it
            $homeCustomize->update([
                'title' => json_encode($data),  // Save the data as a JSON object in the 'title' field
            ]);
        } else {
            // If no data exists, create a new record
            HomeCustomize::create([
                'title' => json_encode($data),  // Save the data as a JSON object in the 'title' field
            ]);
        }
    
        return back()->with('success', 'Data saved successfully!');
    }
    
    public function homesubmit(Request $request)
    {
        $request->validate([
            'banner1' => 'nullable|array',
            'banner1.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'banner2' => 'nullable|array',
            'banner2.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'banner3' => 'nullable|array',
            'banner3.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'mobile_view' => 'nullable|array',
            'mobile_view.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);
    
        // Function to handle image uploads
        $uploadBanners = function ($bannerField) use ($request) {
            $paths = []; // Always start fresh for this field
            if ($request->hasFile($bannerField)) {
                foreach ($request->file($bannerField) as $image) {
                    $filename = time() . '-' . $image->getClientOriginalName();
                    $image->storeAs('public/images', $filename);
                    $paths[] = 'images/' . $filename; // Store only new images
                }
            }
            return $paths; // Return only new images
        };
    
        // Fetch existing data from HomeCustomize
        $homeCustomize = HomeCustomize::first();
    
        // Prepare data with new images (replace old ones)
        $data = [
            'banner1' => json_encode($uploadBanners('banner1')),
            'banner2' => json_encode($uploadBanners('banner2')),
            'banner3' => json_encode($uploadBanners('banner3')),
            'mobile_view' => json_encode($uploadBanners('mobile_view')),
        ];
    
        // Update or create HomeCustomize
        if ($homeCustomize) {
            $homeCustomize->update($data);
        } else {
            HomeCustomize::create($data);
        }
    
        return back()->with('success', 'Banners uploaded and saved successfully!');
    }
    
    
    public function profile()
    {
        $admin = Auth::guard('admin')->user();

        return view('back.admin.setting.profile', compact('admin'));
    }

    public function profileUpdate(Request $request)
{
    // Fetch the currently authenticated admin
    $admin = Auth::guard('admin')->user();

    // Validate the input
    $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:admins,email,' . $admin->id,
        'phone' => 'nullable|string|max:15',
        'password' => 'nullable|min:6',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $admin->name = $request->input('name');
    $admin->last_name = $request->input('last_name');
    $admin->email = $request->input('email');
    $admin->phone = $request->input('phone');

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->input('password'));
    }

    if ($request->hasFile('image')) {
        if ($admin->image && Storage::exists($admin->image)) {
            Storage::delete($admin->image);
        }

        $admin->image = $request->file('image')->store('profiles', 'public');
    }

    $admin->save();

    // Redirect with success message
    return redirect()->back()->with('success', 'Profile updated successfully!');
}

}
