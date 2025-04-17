<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(){
        $categories = Category::paginate(4);
        return view('admin.sub_category.create', compact('categories'));
    }

    public function manage(){
        $subcategories = Subcategory::paginate(4);
        return view('admin.sub_category.manage', compact('subcategories'));
    }

    // Método store para salvar a subcategoria
    public function store(Request $request){
        // Validação do nome da subcategoria e categoria
        $request->validate([
            'subcategory_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Verifica se a categoria existe
        ]);

        // Criar a subcategoria no banco de dados
        $subcategory = new Subcategory();
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->category_id = $request->category_id;
        $subcategory->save(); // Salva a subcategoria

        // Redirecionar ou retornar com sucesso
        return redirect()->route('admin.subcategory.manage')->with('success', 'Subcategoria criada com sucesso!');
    }
}
