<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = Product::paginate();

        return Inertia::render('Dashboard', [
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
        ]);

        Product::create($validated);

        return redirect()->route('dashboard');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
        ]);

        $product->update($validated);

        return redirect()->route('dashboard');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard');
    }
}
