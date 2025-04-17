<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.product.create', compact('categories', 'subcategories'));
    }

    public function manage()
    {
        $currentSeller = Auth::id();
        $products = Product::where('seller_id', $currentSeller)
            ->with(['images', 'category', 'subcategory'])
            ->paginate(4);
        return view('admin.product.manage', compact('products'));
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

            return redirect()->route('admin.product.manage')->with('message', 'Produto adicionado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao adicionar o produto: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::where('seller_id', Auth::id())
            ->with(['images', 'category', 'subcategory'])
            ->findOrFail($id);
        return view('admin.product.edit', compact('product'));
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

            return redirect()->route('admin.product.manage')->with('message', 'Produto atualizado com sucesso!');
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

            return redirect()->route('admin.product.manage')->with('message', 'Produto deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Erro ao deletar o produto: ' . $e->getMessage()]);
        }
    }
    public function procurar(Request $request)
{
    $searchTerm = $request->input('search_term'); // A variável que armazena o termo de busca

    // Verifica se há um termo de pesquisa
    if ($searchTerm) {
        $products = Product::where('product_name', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('category', function($query) use ($searchTerm) {
                $query->where('category_name', 'like', '%' . $searchTerm . '%');
            })
            ->orWhereHas('subcategory', function($query) use ($searchTerm) {
                $query->where('subcategory_name', 'like', '%' . $searchTerm . '%');
            })
            ->with(['images', 'category', 'subcategory'])
            ->get();
    } else {
        // Se não houver termo de pesquisa, retorna todos os produtos
        $products = Product::with(['images', 'category', 'subcategory'])->paginate(1);
    }

    // Retorna os resultados para a view 'resultados.blade.php'
    return view('resultados', compact('products'));
}


public function show($slug)
{
    // Encontra o produto pelo slug
    $product = Product::where('slug', $slug)->with(['images', 'category', 'subcategory'])->first();

    // Verifica se o produto foi encontrado
    if (!$product) {
        abort(404); // Se o produto não for encontrado, retorna um erro 404
    }

    return view('detalhes', compact('product')); // Retorna a view com o produto
}


}