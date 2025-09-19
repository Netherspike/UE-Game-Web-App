<?php

declare(strict_types=1);

namespace App\Http\Controllers\UE;

use App\Actions\Item\CreateItemAction;
use App\Actions\Item\DeleteItemAction;
use App\Actions\Item\UpdateItemAction;
use App\Dtos\ItemDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Item;

//TODO: add error responses in JSON for UE5 to handle
class UEItemController extends Controller
{
    public function __construct(
        protected CreateItemAction $createItemAction,
        protected UpdateItemAction $updateItemAction,
        protected DeleteItemAction $deleteItemAction,
    ) {}

    public function index(): JsonResponse
    {
        //TODO: chunk/yeild this data so php doesnt run out of memory
        return response()->json(Item::all(), 200);
    }

    public function show(Item $item): JsonResponse
    {
        return response()->json($item);
    }

    public function store(ItemStoreRequest $request): JsonResponse
    {
        $itemDto = ItemDto::from($request->validated());
        $item = $this->createItemAction->handle($itemDto);
        return response()->json(['message' => 'Item created successfully!', 'item' => $item], 201);
    }

    public function update(ItemUpdateRequest $request, Item $item): JsonResponse
    {
        $itemDto = ItemDto::from($request->validated());
        $updatedItem = $this->updateItemAction->handle($item, $itemDto);
        return response()->json(['message' => 'Item updated successfully!', 'item' => $updatedItem], 200);
    }

    public function destroy(Item $item): JsonResponse
    {
        $this->deleteItemAction->handle($item);
        return response()->json(['message' => 'Item deleted successfully!'], 200);
    }
}
