<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private ProductService $productService;
    private CategoryService $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        // strona główna sklepu z produktami dla klienta
        $products = $this->productService->getForShop($request);
        $categories = $this->categoryService->getActive();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $request->query('search'),
            'categoryId' => $request->query('category_id')
        ]);
    }
}