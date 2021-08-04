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
            'item1' => $request->item1 ?? null,
            'item2' => $request->item2 ?? null,
            'item3' => $request->item3 ?? null,
            'item4' => $request->item4 ?? null,
            'item5' => $request->item5 ?? null,
            'item6' => $request->item6 ?? null,
            'item7' => $request->item7 ?? null,
            'item8' => $request->item8 ?? null,
            'item9' => $request->item9 ?? null,
            'item10' => $request->item10 ?? null,
            'item11' => $request->item11 ?? null,
            'item12' => $request->item12 ?? null,
            'item13' => $request->item13 ?? null,
            'item14' => $request->item14 ?? null,
            'item15' => $request->item15 ?? null,
            'item16' => $request->item16 ?? null,
            'item17' => $request->item17 ?? null,
            'item18' => $request->item18 ?? null,
            'item19' => $request->item19 ?? null,
            'item20' => $request->item20 ?? null,
        ]);

        return (new TsumiageItemResource($item))
        ->response()
        ->setStatusCode(Response::HTTP_OK);
    }
}
