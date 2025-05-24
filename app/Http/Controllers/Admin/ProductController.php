<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories for the filter dropdown
        $categories = Category::orderBy('name')->get();
        
        // Start building the query
        $query = Product::with('category');
        
        // Apply search filter
        if ($search = $request->query('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply category filter
        if ($categoryId = $request->query('category')) {
            $query->where('category_id', $categoryId);
        }
        
        // Apply status filter
        if ($status = $request->query('status')) {
            switch ($status) {
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'out_of_stock':
                    $query->where('stock', '<=', 0);
                    break;
            }
        }
        
        // Apply sorting
        $sort = $request->query('sort', 'created_at');
        $direction = $request->query('direction', 'desc');
        
        // Validate sort direction
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'desc';
        
        // Validate sort field
        $sortableFields = ['name', 'price', 'created_at', 'stock'];
        $sort = in_array($sort, $sortableFields) ? $sort : 'created_at';
        
        $query->orderBy($sort, $direction);
        
        // Paginate the results
        $perPage = $request->query('per_page', 15);
        $products = $query->paginate($perPage)->withQueryString();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0|gt:price',
            'cost_per_item' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ], [
            'compare_at_price.gt' => 'Le prix de comparaison doit être supérieur au prix de vente',
            'images.*.max' => 'Chaque image ne doit pas dépasser 10 Mo',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Create the product
        $product = Product::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)
                    ->withResponsiveImages()
                    ->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Le produit a été créé avec succès.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0|gt:price',
            'cost_per_item' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:100|unique:products,barcode,' . $product->id,
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:media,id',
        ], [
            'compare_at_price.gt' => 'Le prix de comparaison doit être supérieur au prix de vente',
            'images.*.max' => 'Chaque image ne doit pas dépasser 10 Mo',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Update the product
        $product->update($validated);

        // Handle deleted images
        if ($request->has('deleted_images')) {
            $product->media()
                ->whereIn('id', $request->deleted_images)
                ->delete();
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)
                    ->withResponsiveImages()
                    ->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Le produit a été mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
} 