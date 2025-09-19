<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Character\CreateCharacterAction;
use App\Actions\Character\DeleteCharacterAction;
use App\Actions\Character\GetCharactersAction;
use App\Actions\Character\UpdateCharacterAction;
use App\Dtos\CharacterDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Character\CharacterStoreRequest;
use App\Http\Requests\Character\CharacterUpdateRequest;
use App\Http\Requests\IndexSearchRequest;
use App\Models\Character;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CharacterManagementController extends Controller
{
    public function __construct(
        protected CreateCharacterAction $createCharacterAction,
        protected UpdateCharacterAction $updateCharacterAction,
        protected DeleteCharacterAction $deleteCharacterAction,
        protected GetCharactersAction $getCharactersAction
    ) {}

    public function index(IndexSearchRequest $request): View|JsonResponse
    {
        $characters = $this->getCharactersAction->handle($request->query('search'));

        // If the request was through AJAX assume user is searching so we refresh the HTML table
        if ($request->ajax()) {
            return response()->json([
                'html' => view('management.characters.partials.characters_table', compact('characters'))->render()
            ]);
        }

        return view('management.characters.index', compact('characters'));

    }

    public function create(): View
    {
        return view('management.characters.create');
    }

    public function store(CharacterStoreRequest $request): RedirectResponse
    {
        $characterDto = CharacterDto::from($request->validated());
        $this->createCharacterAction->handle($characterDto);

        return redirect()->route('characters.index')->with('success', 'Character created successfully.');
    }

    public function show(Character $character): RedirectResponse|View
    {
        return view('management.characters.show', compact('character'));
    }

    public function edit(Character $character): RedirectResponse|View
    {
        return view('management.characters.edit', compact('character'));
    }

    public function update(CharacterUpdateRequest $request, Character $character): RedirectResponse
    {
        $characterDto = CharacterDto::from($request->validated());
        $this->updateCharacterAction->handle($character, $characterDto);

        return redirect()->route('characters.index')->with('success', 'Character updated successfully.');
    }

    public function destroy(Character $character): RedirectResponse
    {
        $this->deleteCharacterAction->handle($character);
        return redirect()->route('characters.index')->with('success', 'Character deleted successfully.');
    }
}
