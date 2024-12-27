<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function ProductTypeList($id)
    {
        $service = Service::findOrFail($id);
       
        $data =SubCategory::where('service_id', $id)->orderBy('id', 'desc')->paginate(10);
       
        return view('back.admin.subcategory.list',compact('data','service'));
    }

    public function AddProductType($id)
    { 
        $service = Service::findOrFail($id);
        return view('back.admin.subcategory.add',compact('service'));
    }

    public function SubmitProductType(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'product_type' => 'required|regex:/^[A-Za-z\s&]+$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
           
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = new SubCategory();
        $data->service_id = $id;
        $data->product_type = $request->input('product_type');
       
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('category/image'), $filename);
            $data->image = $filename; // Save the filename in the database
        }
    
        $data->save();

        return redirect()->route('admin.product_type.list',['id' => $id])->with('success', 'Product Added');
    }

    public function EditProductType($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $service = Service::findOrFail($subcategory->service_id);
       
     
        return view('back.admin.subcategory.edit', compact('subcategory','service'));
    }


    public function UpdateProductType(Request $request,$id)
    {
        $subcategory = SubCategory::findOrFail($id); 
    
        $validator = Validator::make($request->all(), [
            'product_type' => 'required|regex:/^[A-Za-z\s&]+$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $subcategory->service_id = $request->service_id;
        $subcategory->product_type = $request->product_type;
    
        if ($request->hasFile('image')) {
          
            if ($subcategory->image && file_exists(public_path('category/image/' . $subcategory->image))) {
                unlink(public_path('category/image/' . $subcategory->image));
            }
    
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('category/image'), $filename);
            $subcategory->image = $filename; // Update the image filename in the database
        }
    
  
        $subcategory->save(); // Save the updated subcategory
    
        return redirect()->route('admin.product_type.list',['id' => $request->service_id])->with('success', 'Product updated successfully.');
    }

    public function DeleteProductType($id)
    {
        $data = SubCategory::findOrFail($id);

        $data->delete(); 
        return redirect()->back()->with('success', 'Product deleted successfully.');

    }

    public function PartList($id)
    {
        // Find the subcategory or fail
        $subcategories = SubCategory::findOrFail($id);
    
        // Fetch products based on subcategory_id and load related models
        $data = Product::where('subcategory_id', $id)
            ->with(['service', 'subCategory'])
            ->orderBy('id', 'desc')
            ->paginate(10);
    
        // Return the view with data and subcategories
        return view('back.admin.product.list', compact('data', 'subcategories'));
    }

    public function PartAdd($id)
    {
        $subcat = SubCategory::findOrFail($id);
       
        $subcategories = SubCategory::findOrFail($id);
       
        $service = Service::findOrFail($subcategories->service_id);
    
        return view('back.admin.product.add', compact('subcategories','service','subcat'));
    }

    public function PartSubmit(Request $request,$id)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
        
            'product_name' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image is optional now
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null; 
        }
    
        // Store the product
        Product::create([
            'service_id' => $request->service_id,
            'subcategory_id' => $id,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'image' => $imagePath, 
        ]);
        return redirect()->route('admin.Part.list',['id'=>$id])->with('success', 'Part added successfully.');
    }

    public function PartEdit($id)
    {
        $data = Product::findOrFail($id);
        $service = Service::findOrFail($data->service_id);
        $subcategories = SubCategory::findOrFail($data->subcategory_id);
        return view('back.admin.product.edit', compact('data', 'service', 'subcategories'));
    }

    public function PartEditUpdate(Request $request,$id)
    {
        $product = Product::findOrFail($id);

        // Validate the incoming data
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
        
            'product_name' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image is optional in update
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image;
        }

        $product->update([
            'service_id' => $request->service_id,
            'subcategory_id' => $request->subcategory_id,
        
            'product_name' => $request->product_name,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

       
        return redirect()->route('admin.Part.list',['id'=>$request->subcategory_id])->with('success', 'Product updated successfully');
    }
   

    public function PartDelete($id)
    {
        $product = Product::findOrFail($id);

        $product->delete(); 

        return redirect()->back()->with('success', 'Part deleted successfully.');
    }

    
}
