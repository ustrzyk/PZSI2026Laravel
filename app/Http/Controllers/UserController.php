<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAll($request);

        return view('users.index', [
            'users' => $users,
            'search' => $request->query('search'),
            'visibility' => $request->query('visibility', 'active')
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->userService->addToDb($request);

        return redirect()->route('users.index')
            ->with('success', 'Użytkownik został dodany.');
    }

    public function edit(int $id)
    {
        $user = $this->userService->getById($id);

        return view('users.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->userService->update($request, $id);

        return redirect()->route('users.index')
            ->with('success', 'Użytkownik został zaktualizowany.');
    }

    public function delete(int $id)
    {
        $this->userService->delete($id);

        return redirect()->route('users.index')
            ->with('success', 'Użytkownik został zablokowany.');
    }

    public function restore(int $id)
    {
        $this->userService->restore($id);

        return redirect()->route('users.index', ['visibility' => 'hidden'])
            ->with('success', 'Użytkownik został odblokowany.');
    }
}