<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    // Exibe o formulário de criação de um novo produto
    public function index()
    {
        return view('seller.product.create');
    }

    // Exibe a lista de produtos do vendedor
    public function manage()
    {
        $currentSeller = Auth::id();
        $products = Product::where('seller_id', $currentSeller)
            ->with(['images', 'category', 'subcategory'])
            ->get();
        return view('seller.product.manage', compact('products'));
    }

    // Função para salvar imagens
    protected function saveImages($product, $images)
    {
        foreach ($images as $index => $file) {
            $path = $file->store('product/images', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'img_path' => $path,
                'is_primary' => $index === 0, // Define a primeira imagem como primária
            ]);
        }
    }

    // Salvar um novo produto
    public function storeproduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'regular_price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $product = Product::create([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'seller_id' => Auth::id(),
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'regular_price' => $request->regular_price,
            ]);

            if ($request->hasFile('images')) {
                $this->saveImages($product, $request->file('images'));
            }

            return redirect()->route('vendor.product.manage')->with('message', 'Produto adicionado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao adicionar o produto: ' . $e->getMessage()])->withInput();
        }
    }

    // Editar um produto
    public function edit($id)
    {
        $product = Product::where('seller_id', Auth::id())
            ->with(['images', 'category', 'subcategory'])
            ->findOrFail($id);
        return view('seller.product.edit', compact('product'));
    }

    // Atualizar um produto
    public function update(Request $request, $id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'regular_price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Atualiza o produto com os novos dados
            $product->update([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'regular_price' => $request->regular_price,
            ]);

            // Remover imagens se o usuário tiver marcado para remover
            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image) {
                        // Apaga a imagem do armazenamento
                        Storage::disk('public')->delete($image->img_path);
                        // Deleta a imagem do banco
                        $image->delete();
                    }
                }
            }

            // Adicionar novas imagens se o usuário fez o upload
            if ($request->hasFile('images')) {
                $this->saveImages($product, $request->file('images'));
            }

            return redirect()->route('vendor.product.manage')->with('message', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar o produto: ' . $e->getMessage()])->withInput();
        }
    }

    // Deletar um produto
    public function destroy($id)
    {
        try {
            $product = Product::where('seller_id', Auth::id())->findOrFail($id);

            // Deletar imagens associadas ao produto
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
