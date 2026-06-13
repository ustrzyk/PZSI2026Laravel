<?php

namespace App\Http\Controllers;

use App\Services\AccessoryService;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    private AccessoryService $accessoryService;

    public function __construct(AccessoryService $accessoryService)
    {
        $this->accessoryService = $accessoryService;
    }

    public function index(Request $request)
    {
        $accessories = $this->accessoryService->getAll($request);

        return view('accessories.index', [
            'accessories' => $accessories,
            'search' => $request->query('search')
        ]);
    }

    public function create()
    {
        return view('accessories.create');
    }

    public function store(Request $request)
    {
        $this->accessoryService->addToDb($request);

        return redirect()->route('accessories.index')
            ->with('success', 'Akcesorium zostało dodane.');
    }

    public function edit(int $id)
    {
        $accessory = $this->accessoryService->getById($id);

        return view('accessories.edit', [
            'accessory' => $accessory
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->accessoryService->update($request, $id);

        return redirect()->route('accessories.index')
            ->with('success', 'Akcesorium zostało zaktualizowane.');
    }

    public function delete(int $id)
    {
        $this->accessoryService->delete($id);

        return redirect()->route('accessories.index')
            ->with('success', 'Akcesorium zostało dezaktywowane.');
    }
}