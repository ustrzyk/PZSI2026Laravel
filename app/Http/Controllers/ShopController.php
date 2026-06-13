<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        // strona główna sklepu z produktami
        $products = $this->productService->getAll($request);

        return view('shop.index', [
            'products' => $products
        ]);
    }
}