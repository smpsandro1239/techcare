<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SellerSubCategoryController extends Controller
{
    // Exibe o formulário para criar uma nova subcategoria
    public function index()
    {
        $categories = Category::all();  // Obtém todas as categorias
        return view('seller.sub_category.create', compact('categories'));  // Passa as categorias para a view
    }

    // Exibe todas as subcategorias
    public function manage()
    {
        $subcategories = Subcategory::all();  // Obtém todas as subcategorias
        return view('seller.sub_category.manage', compact('subcategories'));  // Passa as subcategorias para a view
    }

    // Armazena uma nova subcategoria no banco de dados
    public function store(Request $request)
    {
        // Validação do nome da subcategoria e da categoria
        $request->validate([
            'subcategory_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Verifica se a categoria existe
        ]);

        // Criação da nova subcategoria
        $subcategory = new Subcategory();
        $subcategory->subcategory_name = $request->subcategory_name;
        $subcategory->category_id = $request->category_id;
        $subcategory->save(); // Salva a subcategoria

        // Redireciona para a página de gerenciamento com uma mensagem de sucesso
        return redirect()->route('vendor.subcategory.manage')->with('success', 'Subcategoria criada com sucesso!');
    }

    // Exibe o formulário de edição de uma subcategoria
    public function edit($id)
    {
        // Busca a subcategoria pelo ID
        $subcategory = Subcategory::find($id);
        
        // Se a subcategoria não for encontrada, redireciona com uma mensagem de erro
        if (!$subcategory) {
            return redirect()->route('vendor.subcategory.manage')->with('error', 'Subcategoria não encontrada!');
        }

        $categories = Category::all();  // Para popular o select de categorias na edição
        return view('seller.sub_category.edit', compact('subcategory', 'categories'));  // Passa a subcategoria e categorias para a view
    }

    // Atualiza os dados de uma subcategoria
    public function update(Request $request, $id)
    {
        // Busca a subcategoria pelo ID
        $subcategory = Subcategory::find($id);

        // Se a subcategoria não for encontrada, redireciona com uma mensagem de erro
        if (!$subcategory) {
            return redirect()->route('vendor.subcategory.manage')->with('error', 'Subcategoria não encontrada!');
        }

        // Validação dos dados recebidos para atualização
        $request->validate([
            'subcategory_name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Atualiza a subcategoria
        $subcategory->update([
            'subcategory_name' => $request->subcategory_name,
            'category_id' => $request->category_id,
        ]);

        // Redireciona para a página de gerenciamento de subcategorias com uma mensagem de sucesso
        return redirect()->route('vendor.subcategory.manage')->with('success', 'Subcategoria atualizada com sucesso!');
    }

    // Deleta uma subcategoria
    public function destroy($id)
    {
        // Busca a subcategoria pelo ID
        $subcategory = Subcategory::find($id);

        // Se a subcategoria não for encontrada, redireciona com uma mensagem de erro
        if (!$subcategory) {
            return redirect()->route('vendor.subcategory.manage')->with('error', 'Subcategoria não encontrada!');
        }

        // Deleta a subcategoria
        $subcategory->delete();

        // Redireciona para a página de gerenciamento com uma mensagem de sucesso
        return redirect()->route('vendor.subcategory.manage')->with('success', 'Subcategoria deletada com sucesso!');
    }
}
