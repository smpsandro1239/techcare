<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Método para listar os produtos com paginação
    public function index(Request $request)
    {
        // Recupera os produtos com paginação
        $products = Product::with('images', 'category', 'subcategory', 'seller')->get();

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

    // Método para armazenar um novo produto
    public function storeproduct(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seller_id' => 'required|exists:users,id', // Verificar se o vendedor existe
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'regular_price' => 'required|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validação de imagens
        ]);

        // Criação do produto
        $product = Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'seller_id' => $request->seller_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'regular_price' => $request->regular_price,
        ]);

        // Processar as imagens, se houver
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $index => $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'img_path' => $imagePath,
                    'is_primary' => $index === 0, // Definindo explicitamente a primeira imagem como primária
                ]);
            }
        }

        // Redirecionar com sucesso
        return redirect()->route('admin.product.manage')->with('message', 'Produto adicionado com sucesso!');
    }
}
