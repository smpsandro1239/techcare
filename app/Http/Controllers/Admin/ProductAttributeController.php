<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DefaultAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function index(){
        return view('admin.product_attribute.create');
    }

    public function manage(){
        $allattributes = DefaultAttribute::all();
        return view('admin.product_attribute.manage', compact('allattributes'));
    }

    public function createattribute(Request $request){
            $validate_data = $request->validate([
                'attribute_value'=>'unique:default_attributes|max:100|min:1',
            ]);
    
            DefaultAttribute::create($validate_data);
    
            return redirect()->back()->with('message', 'Default Attribute Added Successfuly');
        }
        public function showattribute($id){
            $attri_info = DefaultAttribute::find($id);
            return view('admin.product_attribute.edit', compact('attri_info'));
        }
    
        public function updateattribute(Request $request,$id){
            $attri = DefaultAttribute::findOrFail($id);
            $validate_data = $request->validate([
                'attribute_value'=>'unique:default_attributes|max:100|min:1',
            ]);
    
            $attri->update($validate_data);
            return redirect()->back()->with( 'message', 'Default Attribute Updated Successfully');
    }
     
     public function deleteattribute($id){
        DefaultAttribute::findOrFail($id)->delete();
        return redirect()->back()->with( 'message', 'Category Delete successfully');
    
     }
    }

