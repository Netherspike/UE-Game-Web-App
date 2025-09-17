<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Actions\Account\DeleteAccountAction;
use App\Actions\Account\UpdateUserAction;
use App\Dtos\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UserUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('account.index', ['user' => Auth::user()]);
    }

    public function edit(): View
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    public function update(UserUpdateRequest $request): RedirectResponse
    {
        $userDto = UserDto::from($request->validated());
        $result = app(UpdateUserAction::class)->handle($userDto);

        if (!$result) {
            // We can safely assume false response indicates this error as the `UserUpdateRequest` will throw other failures
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.'
            ]);
        }
        return redirect()->route('account.index')->with('success', 'Account updated successfully.');
    }

    public function destroy(): RedirectResponse
    {
        app(DeleteAccountAction::class)->handle();

        return redirect('/')->with('success', 'Your account and associated characters have been deleted.');
    }
}
