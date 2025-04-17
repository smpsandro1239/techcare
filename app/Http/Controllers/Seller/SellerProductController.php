<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('seller.product.create', compact('categories', 'subcategories'));
    }

    public function manage()
    {
        $currentSeller = Auth::id();
        $products = Product::where('seller_id', $currentSeller)
            ->with(['images', 'category', 'subcategory'])
            ->paginate(4);
        return view('seller.product.manage', compact('products'));
    }

    protected function saveImages($product, $images)
    {
        foreach ($images as $index => $file) {
            $path = $file->store('product/images', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'img_path' => $path,
                'is_primary' => $index === 0,
            ]);
        }
    }

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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $product->update([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'regular_price' => $request->regular_price,
            ]);

            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete($image->img_path);
                        $image->delete();
                    }
                }
            }

            if ($request->hasFile('images')) {
                $this->saveImages($product, $request->file('images'));
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

            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->img_path);
                $image->delete();
            }

            $product->delete();

            return redirect()->route('vendor.product.manage')->with('message', 'Produto deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao deletar o produto: ' . $e->getMessage()]);
        }
    }
}