<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = $this->categoryService->getAll($request);

        return view('categories.index', [
            'categories' => $categories,
            'search' => $request->query('search'),
            'visibility' => $request->query('visibility', 'active')
        ]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->categoryService->addToDb($request);

        return redirect()->route('categories.index')
            ->with('success', 'Kategoria została dodana.');
    }

    public function edit(int $id)
    {
        $category = $this->categoryService->getById($id);

        return view('categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->categoryService->update($request, $id);

        return redirect()->route('categories.index')
            ->with('success', 'Kategoria została zaktualizowana.');
    }

    public function delete(int $id)
    {
        $this->categoryService->delete($id);

        return redirect()->route('categories.index')
            ->with('success', 'Kategoria została ukryta.');
    }

    public function restore(int $id)
    {
        $this->categoryService->restore($id);

        return redirect()->route('categories.index', ['visibility' => 'hidden'])
            ->with('success', 'Kategoria została przywrócona.');
    }
}