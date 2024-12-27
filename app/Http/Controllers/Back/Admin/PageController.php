<?php

namespace App\Http\Controllers\Back\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function page()
    {   
        $data = Page::orderBy('id', 'desc')->paginate(10);
        return view('back.admin.page.list', compact('data'));
    }
    public function pageAdd()
    {
        return view('back.admin.page.add');
    }

    public function pageSubmit(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',  // Title is required, should be a string and max length of 255
            'slug' => 'nullable|string|max:255|unique:pages,slug',  // Slug is optional, should be a unique field in the pages table
            'details' => 'required|string',  // Details are required and should be a string
        ]);
    
        // If validation passes, proceed to save the page
        $data = new Page();
        $data->title = $request->title;
        $data->slug = $request->slug ?: \Str::slug($request->title); // Automatically generate slug if it's not provided
        $data->details = $request->details;
        $data->save();
    
        // Redirect back with a success message
        return redirect()->route('admin.back.page')->with('success', 'Page Created Successfully');
    }

    public function pageEdit($id)
    {
        $data = Page::FindOrfail($id);
        return view('back.admin.page.edit',[
            'data'=>$data,
        ]);
    }

    public function pageUpdate(Request $request, $id)
{
    $data = Page::findOrFail($id);

    // Validate the incoming request
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|unique:pages,slug,' . $id,
        'details' => 'required',
    ]);

    // Update the page details
    $data->title = $request->title;
    $data->slug = $request->slug;
    $data->details = $request->details;
    $data->save();

    return redirect()->route('admin.back.page')->with('success', 'Page updated successfully!');
}
public function pageDelete($id)
{
    $data = Page::findOrFail($id);


    $data->delete(); 

    return redirect()->route('admin.back.page')->with('success', 'Page deleted successfully.');
}
    
}
