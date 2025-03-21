<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Método para listar os produtos com paginação
    public function index(Request $request)
{
    // Recupera os produtos com paginação
    $products = Product::with('images', 'category', 'subcategory', 'seller')->get();
    
    // Depuração: Mostra o conteúdo da variável $products
    dd($products);

    // Retorna a view com os produtos
    return view('livewire.product-catalog', compact('products'));
}


    // Método para gerenciar avaliações dos produtos
    public function review_manage()
    {
        return view('admin.product.manage_product_review');
    }

    // Método para buscar produtos com base no termo inserido
    public function procurar(Request $request)
    {
        $termo = $request->input('search');

        // Pesquisa por nome ou descrição do produto com paginação
        $produtos = Product::where('product_name', 'like', '%' . $termo . '%')
                            ->orWhere('description', 'like', '%' . $termo . '%')
                            ->paginate(10);

        return view('admin.product.resultados', compact('produtos'));
    }

    // Método para exibir os detalhes de um produto pelo slug
    public function show($slug)
    {
        // Busca o produto pelo slug, carregando categoria, subcategoria e imagens
        $produto = Product::with('category', 'subcategory', 'images')->where('slug', $slug)->first();

        if (!$produto) {
            abort(404, 'Produto não encontrado.');
        }

        return view('admin.product.detalhes', compact('produto'));
    }
}
