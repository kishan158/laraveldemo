<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;

class CategoryController extends Controller
{
    public function CategoryList()
    {
        $data =Category::orderBy('id', 'desc')->paginate(10);
        return view('back.admin.category.list',compact('data'));
    }

    public function AddCategory()
    {
        return view('back.admin.category.add');
    }

    public function SubmitCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|regex:/^[A-Za-z\s&]+$/',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
          
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data = new Category();
        $data->category = $request->input('category');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('category/image'), $filename);
            $data->image = $filename; // Save the filename in the database
        }
        $data->save();
        return redirect()->route('admin.category.list')->with('success', 'category Added');
    }

    public function updateStatus($id)
    {
        $data =Category::findOrFail($id);
        return view('back.admin.category.edit',compact('data'));
    }

    public function CategoryupdateStatus(Request $request,$id)
    {
            $data =Category::findOrFail($id);
         
            $validator = Validator::make($request->all(), [
                'category' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data->category = $request->input('category');

            if ($request->hasFile('image')) {
                if ($data->image && file_exists(public_path('category/image/' . $data->image))) {
                    unlink(public_path('category/image/' . $data->image));
                }

                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('category/image'), $filename);
                $data->image = $filename; 
                }

            
                $data->save();
                return redirect()->route('admin.category.list')->with('success', 'category Updated');

    }

    public function Categorydelete($id)
    {
        $data = Category::findOrFail($id);

        $data->delete(); 

        return redirect()->route('admin.category.list')->with('success', 'Category deleted successfully.');
    }
    public function SubCategoryList()
    {
        $data =SubCategory::orderBy('id', 'desc')->paginate(10);
        return view('back.admin.subcategory.list',compact('data'));
    }

    public function AddSubCategory()
    {
        $data =Category::all();
        return view('back.admin.subcategory.add',compact('data'));
    }

    public function SubmitSubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_type' => 'required|regex:/^[A-Za-z\s&]+$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
           
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $data = new SubCategory();
        $data->product_type = $request->input('product_type');
       
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('category/image'), $filename);
            $data->image = $filename; // Save the filename in the database
        }
    
        $data->save();
        
        return redirect()->route('admin.Subcategory.list')->with('success', 'Subcategory Added');
    }

    public function EditSubCategory($id)
    {
        $subcategory = SubCategory::findOrFail($id);
       
        return view('back.admin.subcategory.edit', compact('subcategory'));
    }

    public function UpdateSubCategory(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id); // Fetch the specific subcategory
    
        $validator = Validator::make($request->all(), [
            'product_type' => 'required|regex:/^[A-Za-z\s&]+$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Image is optional
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Update fields
        $subcategory->product_type = $request->input('product_type');
    
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($subcategory->image && file_exists(public_path('category/image/' . $subcategory->image))) {
                unlink(public_path('category/image/' . $subcategory->image));
            }
    
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('category/image'), $filename);
            $subcategory->image = $filename; // Update the image filename in the database
        }
    
        $subcategory->save(); // Save the updated subcategory
    
        return redirect()->route('admin.Subcategory.list')->with('success', 'Subcategory updated successfully.');
    }

    public function DeleteSubCategory($id)
    {
        $data = SubCategory::findOrFail($id);

        $data->delete(); 

        return redirect()->route('admin.Subcategory.list')->with('success', 'Product Category deleted successfully.');
    }
    
 
}
