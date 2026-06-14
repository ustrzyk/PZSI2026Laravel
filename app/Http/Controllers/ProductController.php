<?php

namespace App\Http\Controllers;

use App\Services\AccessoryService;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;
    private CategoryService $categoryService;
    private AccessoryService $accessoryService;

    public function __construct(
        ProductService $productService,
        CategoryService $categoryService,
        AccessoryService $accessoryService
    ) {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->accessoryService = $accessoryService;
    }

    public function index(Request $request)
    {
        $products = $this->productService->getAll($request);

        return view('products.index', [
            'products' => $products,
            'search' => $request->query('search'),
            'visibility' => $request->query('visibility', 'active')
        ]);
    }

    public function create(Request $request)
    {
        $categories = $this->categoryService->getAll($request);
        $accessories = $this->accessoryService->getAll($request);

        return view('products.create', [
            'categories' => $categories,
            'accessories' => $accessories
        ]);
    }

    public function store(Request $request)
    {
        $this->productService->addToDb($request);

        return redirect()->route('products.index')
            ->with('success', 'Produkt został dodany.');
    }

    public function edit(Request $request, int $id)
    {
        $product = $this->productService->getById($id);
        $categories = $this->categoryService->getAll($request);
        $accessories = $this->accessoryService->getAll($request);

        return view('products.edit', [
            'product' => $product,
            'categories' => $categories,
            'accessories' => $accessories
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->productService->update($request, $id);

        return redirect()->route('products.index')
            ->with('success', 'Produkt został zaktualizowany.');
    }

    public function delete(int $id)
    {
        $this->productService->delete($id);

        return redirect()->route('products.index')
            ->with('success', 'Produkt został ukryty.');
    }

    public function restore(int $id)
    {
        $this->productService->restore($id);

        return redirect()->route('products.index', ['visibility' => 'hidden'])
            ->with('success', 'Produkt został przywrócony.');
    }
}