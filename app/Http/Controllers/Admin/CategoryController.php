<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.create'); // Página para criar a categoria
    }

    public function manage()
    {
        $categories = Category::all(); // Obtém todas as categorias
        return view('admin.category.manage', compact('categories')); // Exibe as categorias
    }

    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'category_name' => 'required|unique:categories|max:255|min:3',
        ]);

        // Criação da nova categoria
        Category::create([
            'category_name' => $request->category_name,
        ]);

        // Redireciona para a página de gerenciamento com uma mensagem de sucesso
        return redirect()->route('category.manage')->with('message', 'Category Created Successfully');
    }
}
