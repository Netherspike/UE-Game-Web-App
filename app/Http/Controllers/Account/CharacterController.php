<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Character\MyCharacterStoreRequest;
use App\Models\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\CharacterService;

class CharacterController extends Controller
{
    public function __construct(
        readonly private CharacterService $characterService
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
        $this->characterService->createCharacter(['user_id' => Auth::user()->id, ...$request->validated()]);
        return redirect()->route('mycharacters.index')->with('success', 'Character created successfully.');
    }

    public function show(Character $character): View
    {
        //TODO: use gate/policy
        $this->characterService->authorizeCharacter($character);
        return view('characters.show', compact('character'));
    }

    public function edit(Character $character): View
    {
        //TODO: use gate/policy
        $this->characterService->authorizeCharacter($character);

        return view('characters.edit', compact('character'));
    }

    public function update(MyCharacterStoreRequest $request, Character $character): RedirectResponse
    {
        //TODO: use gate/policy
        $this->characterService->authorizeCharacter($character);
        $this->characterService->updateCharacter($character, $request->validated());
        return redirect()->route('mycharacters.index')->with('success', 'Character updated successfully.');
    }

    public function destroy(Character $character): RedirectResponse
    {
        //TODO: use gate/policy
        $this->characterService->authorizeCharacter($character);
        $this->characterService->deleteCharacter($character);

        return redirect()->route('mycharacters.index')->with('success', 'Character deleted successfully.');
    }


}
