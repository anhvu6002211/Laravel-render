<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $categorySlug = $request->get('category');

        $query = Product::with('category');
        $selectedCategory = null;
        if ($categorySlug) {
            $selectedCategory = Category::where('slug', $categorySlug)->first();
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $priceMin = $request->get('price_min');
        $priceMax = $request->get('price_max');
        if (is_numeric($priceMin)) {
            $query->where('price', '>=', $priceMin);
        }
        if (is_numeric($priceMax)) {
            $query->where('price', '<=', $priceMax);
        }

        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'popular'    => $query->orderBy('view', 'desc'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();


        return view('shop.index', compact('categories', 'products', 'selectedCategory', 'sort'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        $categories = Category::all();

        $query = Product::with('category');
        if ($keyword) {
            $query->where(function ($builder) use ($keyword) {
                $builder->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        } else {
            $query->whereRaw('1 = 0');
        }

        $products = $query->paginate(12)->withQueryString();

        return view('shop.search', compact('products', 'keyword', 'categories'));
    }
}
