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
        // strona główna sklepu pokazuje kategorie i produkty promowane
        $promotedProducts = $this->productService->getPromotedForShop($request);
        $categories = $this->categoryService->getActive();

        return view('shop.index', [
            'promotedProducts' => $promotedProducts,
            'categories' => $categories,
            'search' => $request->query('search'),
            'categoryId' => $request->query('category_id')
        ]);
    }

    public function category(Request $request, int $id)
    {
        // strona jednej kategorii pokazuje tylko produkty z tej kategorii
        $products = $this->productService->getForCategory($request, $id);
        $categories = $this->categoryService->getActive();
        $currentCategory = $categories->firstWhere('Id', $id);

        abort_if(!$currentCategory, 404);

        return view('shop.category', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $currentCategory,
            'search' => $request->query('search')
        ]);
    }

    public function show(int $id)
    {
        // szczegóły jednego aktywnego produktu
        $product = $this->productService->getActiveByIdForShop($id);

        return view('shop.show', [
            'product' => $product
        ]);
    }
}