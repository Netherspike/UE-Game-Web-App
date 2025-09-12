<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserStoreRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index(Request $request): View|JsonResponse
    {
        $search = $request->query('search');

        $users = $this->userService->getPaginatedUsers($search);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('management.users.partials.users_table', compact('users'))->render()
            ]);
        }

        return view('management.users.index', compact('users', 'search'));
    }

    public function create(): View
    {
        return view('management.users.create');
    }


    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->userService->createUser($request->validated());

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function show(Request $request, User $user): View
    {
        // Get the previous URL from the "from" parameter or fall back to the actual previous URL
        $previousUrl = $request->query('from', url()->previous());

        return view('management.users.show', compact('user', 'previousUrl'));
    }

    public function edit(User $user): View
    {
        return view('management.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $this->userService->updateUser($user, $data);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->userService->deleteUser($user);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
