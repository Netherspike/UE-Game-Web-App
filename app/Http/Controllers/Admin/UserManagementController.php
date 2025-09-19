<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Account\CreateAccountAction;
use App\Actions\Account\DeleteAccountAction;
use App\Actions\Account\UpdateAccountAction;
use App\Dtos\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function __construct(
        protected CreateAccountAction $createAccountAction,
        protected UpdateAccountAction $updateAccountAction,
        protected DeleteAccountAction $deleteAccountAction,
    ) {}

    public function index(Request $request): View|JsonResponse
    {
        // TODO: create custom request to validate search string and move to action
        $search = $request->query('search');

        $query = User::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', $search . '%')
                ->orWhere('email', 'LIKE', $search . '%');
        }

        $users = $query->orderBy('id', 'desc')
            ->paginate(config('pagination.per_page', 10));

        // If the request was through AJAX assume user is searching so we refresh the HTML table
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
        $userDto = UserDto::from($request->validated());
        $this->createAccountAction->handle($userDto);

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
        $userDto = UserDto::from($request->all());
        $this->updateAccountAction->handle($userDto, $user);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->deleteAccountAction->handle($user);

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
