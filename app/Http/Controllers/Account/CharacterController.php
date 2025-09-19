<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Actions\Character\CreateCharacterAction;
use App\Actions\Character\DeleteCharacterAction;
use App\Actions\Character\UpdateCharacterAction;
use App\Dtos\CharacterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Character\MyCharacterStoreRequest;
use App\Http\Requests\Character\MyCharacterUpdateRequest;
use App\Models\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CharacterController extends Controller
{
    public function __construct(
        protected CreateCharacterAction $createCharacterAction,
        protected UpdateCharacterAction $updateCharacterAction,
        protected DeleteCharacterAction $deleteCharacterAction,
    ) {}

    public function index(): View
    {
        return view('characters.index', ['characters' => Auth::user()->characters]);
    }

    public function create(): View
    {
        return view('characters.create');
    }

    public function store(MyCharacterStoreRequest $request): RedirectResponse
    {
        $characterDto = CharacterDto::from(['user_id' => Auth::id(), ...$request->validated()]);
        $this->createCharacterAction->handle($characterDto);

        return redirect()->route('mycharacters.index')->with('success', 'Character created successfully.');
    }

    public function show(Character $character): View
    {
        Gate::authorize('access_character', $character);

        return view('characters.show', compact('character'));
    }

    public function edit(Character $character): View
    {
        Gate::authorize('access_character', $character);

        return view('characters.edit', compact('character'));
    }

    public function update(MyCharacterUpdateRequest $request, Character $character): RedirectResponse
    {
        Log::info('here');
        Gate::authorize('access_character', $character);

        $characterDto = CharacterDto::from(['user_id' => Auth::id(), ...$request->validated()]);
        Log::info(array_filter($characterDto->toArray()));
        $this->updateCharacterAction->handle($character, $characterDto);

        return redirect()->route('mycharacters.index')->with('success', 'Character updated successfully.');
    }

    public function destroy(Character $character): RedirectResponse
    {
        Gate::authorize('access_character', $character);

        $this->deleteCharacterAction->handle($character);

        return redirect()->route('mycharacters.index')->with('success', 'Character deleted successfully.');
    }


}
