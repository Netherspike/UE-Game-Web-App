<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Actions\Account\DeleteAccountAction;
use App\Actions\Account\UpdateAccountAction;
use App\Dtos\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __construct(
        protected UpdateAccountAction $updateAccountAction,
        protected DeleteAccountAction $deleteAccountAction
    ) {}

    public function show(): View
    {
        return view('account.show', ['user' => Auth::user()]);
    }

    public function edit(): View
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    public function update(UserUpdateRequest $request): RedirectResponse
    {
        $userDto = UserDto::from($request->validated());
        $result = $this->updateAccountAction->handle($userDto);

        if (!$result) {
            // We know false response indicates this error as the `UserUpdateRequest` validates everything else
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.'
            ]);
        }

        return redirect()->route('account.show')->with('success', 'Account updated successfully.');
    }

    public function destroy(): RedirectResponse
    {
        $this->deleteAccountAction->handle(Auth::user());

        return redirect('/')->with('success', 'Your account and associated characters have been deleted.');
    }
}
