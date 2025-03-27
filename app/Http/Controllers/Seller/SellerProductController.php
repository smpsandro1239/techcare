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

    // Função reutilizável para salvar imagens
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

    // Função para salvar um novo produto
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
            // Criando o produto
            $product = Product::create([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'seller_id' => Auth::id(),
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'regular_price' => $request->regular_price,
            ]);

            // Salvando as imagens do produto, se houver
            if ($request->hasFile('images')) {
                $this->saveImages($product, $request->file('images'));
            }

            return redirect()->route('vendor.product.manage')->with('message', 'Produto adicionado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao adicionar o produto: ' . $e->getMessage()])->withInput();
        }
    }

    // Função para editar um produto existente
    public function edit($id)
    {
        $product = Product::where('seller_id', Auth::id())
            ->with(['images', 'category', 'subcategory'])
            ->findOrFail($id);
        return view('seller.product.edit', compact('product'));
    }

    // Função para atualizar um produto existente
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
            // Atualizando o produto
            $product->update([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'regular_price' => $request->regular_price,
            ]);

            // Atualizar imagens, se fornecidas
            if ($request->hasFile('images')) {
                // Deletar imagens antigas
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->img_path);
                    $image->delete();
                }

                // Salvar novas imagens
                $this->saveImages($product, $request->file('images'));
            }

            return redirect()->route('vendor.product.manage')->with('message', 'Produto atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao atualizar o produto: ' . $e->getMessage()])->withInput();
        }
    }

    // Função para deletar um produto
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
