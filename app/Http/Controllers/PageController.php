<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function warranty()
    {
        return view('pages.policy', [
            'type' => 'warranty',
            'title' => 'Chính sách bảo hành',
            'icon' => 'verified_user'
        ]);
    }

    public function returns()
    {
        return view('pages.policy', [
            'type' => 'returns',
            'title' => 'Chính sách đổi trả',
            'icon' => 'restart_alt'
        ]);
    }

    public function shipping()
    {
        return view('pages.policy', [
            'type' => 'shipping',
            'title' => 'Chính sách giao hàng',
            'icon' => 'local_shipping'
        ]);
    }
}
