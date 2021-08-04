<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TsumiageItem;
use App\Http\Resources\TsumiageItem as TsumiageItemResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ItemRequest;

class TsumiageItemController extends Controller
{
    public function show(TsumiageItem $item)
    {
        $this->authorize('view', $item);
        return new TsumiageItemResource($item);
    }

    public function update(ItemRequest $request, TsumiageItem $item)
    {
        $this->authorize('update', $item);
        $item->update([
            'item1' => $request->item1,
            'item2' => $request->item2,
            'item3' => $request->item3,
            'item4' => $request->item4,
            'item5' => $request->item5,
        ]);

        return (new TsumiageItemResource($item))
        ->response()
        ->setStatusCode(Response::HTTP_OK);
    }
}
