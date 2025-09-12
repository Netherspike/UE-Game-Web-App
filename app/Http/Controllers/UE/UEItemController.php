<?php

declare(strict_types=1);

namespace App\Http\Controllers\UE;

use App\Http\Controllers\Controller;
use App\Services\ItemService;
use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Item;

class UEItemController extends Controller
{
    public function __construct(
        private readonly ItemService $itemService
    ) {}

    public function index(): JsonResponse
    {
        //TODO: chunk/yeild this data so php doesnt run out of memory
        $items = $this->itemService->getAllItems();
        return response()->json($items, 200);
    }

    public function show(Item $item): JsonResponse
    {
        return response()->json($item);
    }

    public function store(ItemStoreRequest $request): JsonResponse
    {
        $item = $this->itemService->createItem($request->validated());
        return response()->json(['message' => 'Item created successfully!', 'item' => $item], 201);
    }

    public function update(ItemUpdateRequest $request, Item $item): JsonResponse
    {
        $updatedItem = $this->itemService->updateItem($item, $request->validated());
        return response()->json(['message' => 'Item updated successfully!', 'item' => $updatedItem], 200);
    }

    public function destroy(Item $item): JsonResponse
    {
        $this->itemService->deleteItem($item);
        return response()->json(['message' => 'Item deleted successfully!'], 200);
    }
}
