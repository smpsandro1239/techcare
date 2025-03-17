<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
 public function index(){
   $categories = Category::all();
    return view('admin.sub_category.create', compact('categories'));
 }

 public function manage(){
   $subcategories = Subcategory::all();
    return view('admin.sub_category.manage',compact('subcategories'));
 }
}
