<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SellerCategoryController extends Controller
{
    // Exibe o formulário para criar uma nova categoria
    public function index()
    {
        return view('seller.category.create'); // Página para criar a categoria
    }

    // Exibe todas as categorias existentes
    public function manage()
    {
        $categories = Category::paginate(4); // Obtém todas as categorias
        return view('seller.category.manage', compact('categories')); // Exibe as categorias
    }

    // Armazena uma nova categoria no banco de dados
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'category_name' => 'required|unique:categories|max:255|min:3', // Validação
        ]);

        // Criação da nova categoria
        Category::create([
            'category_name' => $request->category_name,
        ]);

        // Redireciona para a página de gerenciamento com uma mensagem de sucesso
        return redirect()->route('vendor.category.manage')->with('message', 'Category Created Successfully');
    }

    // Exibe o formulário de edição de uma categoria específica
    public function edit($id)
    {
        // Busca a categoria pelo ID
        $category = Category::find($id);

        // Se a categoria não for encontrada, redireciona com uma mensagem de erro
        if (!$category) {
            return redirect()->route('vendor.category.manage')->with('error', 'Category not found!');
        }

        // Retorna a view de edição passando a categoria
        return view('seller.category.edit', compact('category'));
    }

    // Atualiza os dados de uma categoria no banco de dados
    public function update(Request $request, $id)
    {
        // Busca a categoria pelo ID
        $category = Category::find($id);

        // Se a categoria não for encontrada, redireciona com uma mensagem de erro
        if (!$category) {
            return redirect()->route('vendor.category.manage')->with('error', 'Category not found!');
        }

        // Validação dos dados recebidos para atualização
        $request->validate([
            'category_name' => 'required|max:255', // Validando o nome da categoria
        ]);

        // Atualiza a categoria no banco de dados
        $category->update([
            'category_name' => $request->category_name, // Atualiza o nome da categoria
        ]);

        // Redireciona para o gerenciamento de categorias com uma mensagem de sucesso
        return redirect()->route('vendor.category.manage')->with('message', 'Category updated successfully!');
    }

    // Deleta uma categoria do banco de dados
    public function destroy($id)
    {
        // Busca a categoria pelo ID
        $category = Category::find($id);

        // Se a categoria não for encontrada, redireciona com uma mensagem de erro
        if (!$category) {
            return redirect()->route('vendor.category.manage')->with('error', 'Category not found!');
        }

        // Deleta a categoria
        $category->delete();

        // Redireciona para a página de gerenciamento com uma mensagem de sucesso
        return redirect()->route('vendor.category.manage')->with('message', 'Category deleted successfully!');
    }
}
