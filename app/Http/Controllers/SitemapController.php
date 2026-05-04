<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $pages = [
            route('home'),
            route('shop.index'),
            route('pages.about'),
            route('pages.contact'),
            route('pages.warranty'),
            route('pages.returns'),
            route('pages.shipping'),
        ];

        $categories = Category::select('id', 'updated_at')->get();
        $products = Product::select('id', 'updated_at')->get();

        return response()
            ->view('sitemap', compact('pages', 'categories', 'products'))
            ->header('Content-Type', 'application/xml');
    }
}
