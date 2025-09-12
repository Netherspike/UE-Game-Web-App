<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserUpdateRequest;
use App\Services\AccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __construct(private readonly AccountService $accountService) {}

    public function index(): View
    {
        $user = Auth::user();
        $characters = $this->accountService->getUserCharacters();

        return view('account.index', compact('user', 'characters'));
    }

    public function edit(): View
    {
        $user = Auth::user();

        return view('account.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request): RedirectResponse
    {
        // If password needs to be updated, verify the current password
        if ($request->filled('password')) {
            $success = $this->accountService->updatePassword($request->current_password, $request->password);

            if (!$success) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }
        }

        $this->accountService->updateAccountDetails($request->only(['name', 'email']));

        return redirect()->route('account.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(): RedirectResponse
    {
        $this->accountService->deleteAccount();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
