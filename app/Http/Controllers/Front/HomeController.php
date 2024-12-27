<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorService;
use Illuminate\Support\Facades\Session;
use App\Models\Service;
use App\Models\Package;
use App\Models\Customer;
use App\Models\HomeCustomize;
use App\Models\SubService;
use App\Models\Page;
use App\Models\Product;
use App\Models\ServiceTitle;


use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    public function index()
    {
      $data = Service::where('status', '1')->get();
      $services = Service::with('packages')->get();
        
     
      $Images = HomeCustomize::first();
   
      $title = $Images ? json_decode($Images->title, true) : null;
 
      $banner1 = $Images ? json_decode($Images->banner1, true) : null;
      $banner2 = $Images ? json_decode($Images->banner2, true) : null;
      $banner3 = $Images ? json_decode($Images->banner3, true) : null;
      $mobile_view = $Images ? json_decode($Images->mobile_view, true) : null;
// dd($mobile_view);
      return view('front.index', compact('data','title', 'banner1', 'banner2', 'banner3','services','mobile_view'));
    }
  
    public function search(Request $request)
{
    $query = $request->get('query');
    
    // Search for services and their related packages
    $services = Service::with('packages')
        ->where('service', 'LIKE', "%$query%")
        ->get();
    
    return response()->json($services);
}
    public function page($slug)
    {   $page = Page::where('slug', $slug)->firstOrFail();  

        $Images = HomeCustomize::first();
     
        $title = $Images ? json_decode($Images->title, true) : null;
        return view('front.page', [
            'page' => $page,
            'Images'=>$Images,
            'title'=>$title,
        ]);
    }
    public function package($id)
    {   
        $Images = HomeCustomize::first();
     
        $title = $Images ? json_decode($Images->title, true) : null;
        $packages = Package::with('servicetitle')->where('service_id', $id)->get();
        $serviceTitles = $packages->pluck('servicetitle')->unique('id');
        $data = Service::where('status', '1')->get();
        $cart = session('cart', []);
        $service = Service::find($id);
        $products = Product::with(['service', 'subCategory'])
        ->where('service_id', $id)
        ->get()
        ->groupBy('subcategory_id');
        $serviceName = $service->service; 
        $serviceId = $service->id;
        // dd( $packages);
        return view('front.package', compact('packages', 'serviceName','serviceTitles', 'serviceId','data','title','products'));
    }
  
 

    public function AddToCart(Request $request)
    {
        $cartInput = $request->input('cart');
       
          if (is_array($cartInput)) {
              $cart = $cartInput;
          } else {
              $cart = json_decode($cartInput, true);
             }
           
      if (empty($cart)) {
          return redirect()->back()->with('error', 'Cart is empty!');
      }
      session(['cart' => $cart]);

      return redirect()->route('front.checkout')->with('success', 'Cart added successfully!');
      
    }

    public function checkout()
    {
        $Images = HomeCustomize::first();
     
        $title = $Images ? json_decode($Images->title, true) : null;
        $services = Service::with('packages')->get();
    
        $cart = session('cart');
    
       
        if (empty($cart)) {
            return redirect()->route('front.package')->with('error', 'Your cart is empty!');
        }
    
        $grandTotal = 0;
    
        foreach ($cart as &$item) {
            if (isset($item['package_id'])) {
                $package = Package::find($item['package_id']);
    
                if ($package) {
                    $item['package'] = $package->package; 
                    $item['price'] = $package->price;     
                    $grandTotal += $item['quantity'] * $item['price'];
                }

                // dd($package);
            }
        }
 
        return view('front.checkout', compact('cart', 'grandTotal','services','title' ));
    }
    
    
    
}
