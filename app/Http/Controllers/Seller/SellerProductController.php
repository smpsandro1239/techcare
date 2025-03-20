<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    public function index()
    {
        return view('seller.product.create');
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Criando o produto
        $product = Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'seller_id' => Auth::id(),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
        ]);

        // Salvando as imagens do produto, se houver
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

        return redirect()->back()->with('message', 'Product Added Successfully');
    }
    public function edit($id)
{
    $product = Product::where('seller_id', Auth::id())->findOrFail($id);
    return view('seller.product.edit', compact('product'));
}

public function update(Request $request, $id)
{
    $product = Product::where('seller_id', Auth::id())->findOrFail($id);

    $request->validate([
        'product_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'nullable|exists:subcategories,id',
        'regular_price' => 'required|numeric|min:0',
    ]);

    $product->update([
        'product_name' => $request->product_name,
        'description' => $request->description,
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'regular_price' => $request->regular_price,
    ]);

    return redirect()->route('vendor.product.manage')->with('message', 'Produto atualizado com sucesso!');
}
public function destroy($id)
{
    $product = Product::where('seller_id', Auth::id())->findOrFail($id);
    
    // Deletar imagens associadas, se houver
    $product->images()->delete();
    
    // Deletar o produto
    $product->delete();

    return redirect()->route('vendor.product.manage')->with('message', 'Produto deletado com sucesso!');
}


}
