<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Character\CharacterStoreRequest;
use App\Http\Requests\Character\CharacterUpdateRequest;
use App\Models\Character;
use App\Services\CharacterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CharacterManagementController extends Controller
{
    public function __construct(
        readonly private CharacterService $characterService
    ) {}

    public function index(Request $request): View|JsonResponse
    {
        $search = $request->input('search');

        $characters = $this->characterService->getPaginatedCharacters($search);

        // If the request was through AJAX assume user is searching so we refresh the HTML table
        if ($request->ajax()) {
            return response()->json([
                'html' => view('management.characters.partials.characters_table', compact('characters'))->render()
            ]);
        }

        return view('management.characters.index', compact('characters', 'search'));

    }

    public function create(): View
    {
        return view('management.characters.create');
    }

    public function store(CharacterStoreRequest $request): RedirectResponse
    {
        $this->characterService->createCharacter($request->validated());
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
        $this->characterService->updateCharacter($character, $request->validated());
        return redirect()->route('characters.index')->with('success', 'Character updated successfully.');
    }

    public function destroy(Character $character): RedirectResponse
    {
        $this->characterService->deleteCharacter($character);
        return redirect()->route('characters.index')->with('success', 'Character deleted successfully.');
    }
}
