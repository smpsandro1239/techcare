<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class MasterSubCategoryController extends Controller
{
    public function storesubcat(Request $request){
        $validate_data = $request->validate([
            'subcategory_name'=>'unique:subcategories|max:100|min:5',
            'category_id'=>"required|exists:categories,id"
        ]);

      Subcategory::create($validate_data);

        return redirect()->back()->with('message', 'Sub Category Added Successfuly');
    }

    public function showsubcatAdmin($id){
        $subcategory_info = Subcategory::find($id);
        return view('admin.sub_category.edit', compact('subcategory_info'));
    }

    public function updatesubcat(Request $request,$id){
        $subcategory = Subcategory::findOrFail($id);
        $validate_data = $request->validate([
            'subcategory_name'=>'unique:subcategories|max:100|min:5'
                ]);
        $subcategory->update($validate_data);
        return redirect()->back()->with( 'message', 'Sub Category Updated Successfully');
}
 
 public function deletesubcat($id){
    Subcategory::findOrFail($id)->delete();
    return redirect()->back()->with( 'message', 'Sub Category Delete successfully');

 }
 public function showsubcatVendor($id){
    $subcategory_info = Subcategory::find($id);
    return view('seller.sub_category.edit', compact('subcategory_info'));
}
}
