<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private function rules(int $id = 0, ?string $currentCategory = null): array
    {
        $categories = Category::active()->pluck('name')->toArray();
        if ($currentCategory && !in_array($currentCategory, $categories, true)) {
            $categories[] = $currentCategory;
        }

        return [
            'name'              => ['required', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price'             => ['required', 'numeric', 'min:0', 'max:99999999'],
            'sale_price'        => ['nullable', 'numeric', 'min:0'],
            'cost_price'        => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'sku'               => ['nullable', 'string', 'max:100', "unique:products,sku,{$id}"],
            'stock'             => ['required', 'integer', 'min:0'],
            'category'          => ['required', 'string', 'in:' . implode(',', $categories)],
            'brand'             => ['nullable', 'string', 'max:100'],
            'status'            => ['required', 'in:active,inactive,out_of_stock'],
            'is_featured'       => ['boolean'],
            'is_on_sale'        => ['boolean'],
            'image'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'gallery.*'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $products     = $query->latest()->paginate(15)->withQueryString();
        $trashedCount = Product::onlyTrashed()->count();

        return view('admin.products.index', compact('products', 'trashedCount'));
    }

    public function create()
    {
        $categories = Category::active()->pluck('name');
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_on_sale']  = $request->boolean('is_on_sale');
        $validated['created_by']  = Auth::guard('admin')->id();
        $validated['slug']        = Str::slug($validated['name']);

        // Ensure unique slug
        $slug  = $validated['slug'];
        $count = 1;
        while (Product::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $slug . '-' . $count++;
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle gallery uploads
        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $validated['gallery'] = $gallery;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product "' . $validated['name'] . '" created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->pluck('name');
        if (!$categories->contains($product->category)) {
            $categories->push($product->category);
        }
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->rules($product->id, $product->category));

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_on_sale']  = $request->boolean('is_on_sale');

        // Handle main image
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Handle gallery
        if ($request->hasFile('gallery')) {
            if ($product->gallery) {
                foreach ($product->gallery as $old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $validated['gallery'] = $gallery;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->latest()->paginate(20);
        return view('admin.products.trashed', compact('products'));
    }

    public function restore(int $id)
    {
        Product::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Product restored successfully.');
    }

    public function forceDelete(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->forceDelete();
        return back()->with('success', 'Product permanently deleted.');
    }
}
