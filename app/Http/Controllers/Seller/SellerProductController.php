<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    public function index()
    {
        return view('seller.product.create');
    }

    public function manage()
    {
        $currentSeller = Auth::id();
        $products = Product::where('seller_id', $currentSeller)
            ->with(['images', 'category', 'subcategory'])
            ->get();
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
            'discounted_price' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,pre_order',
            'visibility' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Criando o produto
            $product = Product::create([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'seller_id' => Auth::id(),
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'regular_price' => $request->regular_price,
                'discounted_price' => $request->discounted_price,
                'tax_rate' => $request->tax_rate,
                'stock_quantity' => $request->stock_quantity,
                'stock_status' => $request->stock_status,
                'visibility' => $request->visibility,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'status' => $request->status,
            ]);

            // Salvando as imagens do produto, se houver
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('product/images', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'img_path' => $path,
                        'is_primary' => $index === 0, // Define a primeira imagem como primária
                    ]);
                }
            }

            return redirect()->route('vendor.product.manage')->with('message', 'Produto adicionado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao adicionar o produto: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::where('seller_id', Auth::id())
            ->with(['images', 'category', 'subcategory'])
            ->findOrFail($id);
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
            'discounted_price' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,pre_order',
            'visibility' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $product->update([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'regular_price' => $request->regular_price,
                'discounted_price' => $request->discounted_price,
                'tax_rate' => $request->tax_rate,
                'stock_quantity' => $request->stock_quantity,
                'stock_status' => $request->stock_status,
                'visibility' => $request->visibility,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'status' => $request->status,
            ]);

            // Atualizar imagens, se fornecidas
            if ($request->hasFile('images')) {
                // Deletar imagens antigas
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->img_path);
                    $image->delete();
                }

                // Adicionar novas imagens
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('product/images', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'img_path' => $path,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            return redirect()->route('vendor.product.manage')->with('message', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar o produto: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::where('seller_id', Auth::id())->findOrFail($id);

            // Deletar imagens associadas
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->img_path);
                $image->delete();
            }

            // Deletar o produto
            $product->delete();

            return redirect()->route('vendor.product.manage')->with('message', 'Produto deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao deletar o produto: ' . $e->getMessage()]);
        }
    }
}