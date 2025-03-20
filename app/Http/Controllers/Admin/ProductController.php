<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;  
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Método para a página inicial de gerenciamento de produtos
    public function index()
{
    // Busca todos os produtos no banco de dados
    $products = Product::all();  // 
    
    // Retorna a view com os produtos
    return view('admin.product.manage', compact('products'));
}

    // Método para revisar o gerenciamento de produtos
    public function review_manage() {
        return view('admin.product.manage_product_review');
    }

    // Método para procurar os produtos com base no termo inserido
    public function procurar(Request $request)
    {
        // Captura o valor da pesquisa que o usuário digitou
        $termo = $request->input('search');
        
        // Realiza a pesquisa no banco de dados nas colunas `product_name` e `description`
        $produtos = Product::where('product_name', 'like', '%' . $termo . '%')
                            ->orWhere('description', 'like', '%' . $termo . '%')
                            ->get();  // Obtém os produtos encontrados
        
        // Retorna a view com os resultados da pesquisa
        return view('admin.product.resultados', compact('produtos'));
    }

    // Método para exibir os detalhes de um produto
    public function show($id)
    {
        // Carrega o produto e suas relações (categoria, subcategoria, loja e imagens)
        $produto = Product::with('category', 'subcategory', 'images')->findOrFail($id);
        
        // Retorna a view com os detalhes do produto
        return view('admin.product.detalhes', compact('produto'));
    }
}
