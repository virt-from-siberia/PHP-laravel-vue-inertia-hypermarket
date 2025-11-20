<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TestController extends Controller
{
  /**
   * Display a listing of products
   * 
   * @param Request $request
   * @return \Inertia\Response
   */
  public function index(Request $request)
  {
    // Query builder with relationships
    $products = Product::query()
      ->with(['category', 'images'])
      ->when($request->search, function ($query, $search) {
        $query->where('name', 'like', "%{$search}%")
          ->orWhere('description', 'like', "%{$search}%");
      })
      ->orderBy('created_at', 'desc')
      ->paginate(15);

    // Array operations
    $categories = Category::all()->map(function ($category) {
      return [
        'id' => $category->id,
        'name' => $category->name,
        'slug' => $category->slug,
        'products_count' => $category->products()->count(),
      ];
    });

    // Database transactions
    DB::transaction(function () use ($products) {
      foreach ($products as $product) {
        $product->update(['views' => $product->views + 1]);
      }
    });

    return Inertia::render('Products/Index', [
      'products' => $products,
      'categories' => $categories,
      'filters' => $request->only(['search', 'category']),
      'stats' => $this->getStatistics(),
    ]);
  }

  /**
   * Store a new product
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'price' => 'required|numeric|min:0',
      'category_id' => 'required|exists:categories,id',
      'description' => 'nullable|string',
      'is_active' => 'boolean',
    ]);

    $product = Product::create($validated);

    return redirect()->route('products.show', $product)
      ->with('success', 'Product created successfully!');
  }

  /**
   * Get statistics
   */
  private function getStatistics(): array
  {
    $total = Product::count();
    $active = Product::where('is_active', true)->count();
    $revenue = DB::table('orders')
      ->sum('total_amount');

    return compact('total', 'active', 'revenue');
  }

  // Magic methods example
  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }
}
