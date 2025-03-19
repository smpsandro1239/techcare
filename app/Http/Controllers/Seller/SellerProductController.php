<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Auth;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    public function index()
    {
        $authuserid = Auth::id(); // Forma mais curta de pegar o ID do usuário autenticado
        return view('seller.product.create'); // Apenas retorna a view sem a variável 'stores'
    }

    public function manage()
    {
        $currentSeller = Auth::id();
        $products = Product::where('seller_id', $currentSeller)->get();
        return view('seller.product.manage', compact('products'));
    }

    public function storeproduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'regular_price' => 'required|numeric|min:0',
            // Não precisa mais de validações para os campos removidos
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Criando o produto corretamente, sem os campos removidos
        $product = Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'seller_id' => Auth::id(), // Associa o produto ao vendedor autenticado
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'regular_price' => $request->regular_price,
            // Removendo os campos removidos do array de criação
        ]);

        // Verificando se há imagens para salvar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('product/images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'img_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Produto adicionado com sucesso');
    }
}

