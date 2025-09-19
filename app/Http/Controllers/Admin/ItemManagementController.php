<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Item\CreateItemAction;
use App\Actions\Item\DeleteItemAction;
use App\Actions\Item\UpdateItemAction;
use App\Dtos\ItemDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemManagementController extends Controller
{
    public function __construct(
        protected CreateItemAction $createItemAction,
        protected UpdateItemAction $updateItemAction,
        protected DeleteItemAction $deleteItemAction,
    ) {}

    public function index(Request $request): View|JsonResponse
    {
        //TODO: custom request to validate search string
        $search = $request->query('search');
        $items = app(ItemService::class)->getPaginatedItems($search);

        // If the request was through AJAX assume user is searching so we refresh the HTML table
        if ($request->ajax()) {
            return response()->json([
                'html' => view('management.items.partials.items_table', compact('items'))->render()
            ]);
        }

        return view('management.items.index', compact('items'));
    }

    public function create(): View
    {
        return view('management.items.create');
    }

    public function store(ItemStoreRequest $request): RedirectResponse
    {
        $itemDto = ItemDto::from($request->validated());
        $this->createItemAction->handle($itemDto);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show(Item $item): View
    {
        return view('management.items.show', compact('item'));
    }

    public function edit(Item $item): View
    {
        return view('management.items.edit', compact('item'));
    }

    public function update(ItemUpdateRequest $request, Item $item): RedirectResponse
    {
        $itemDto = ItemDto::from($request->validated());
        $this->updateItemAction->handle($item, $itemDto);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $this->deleteItemAction->handle($item);

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
