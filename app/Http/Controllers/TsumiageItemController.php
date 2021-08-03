<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TsumiageItem;
use App\Http\Resources\TsumiageItem as TsumiageItemResource;

class TsumiageItemController extends Controller
{
    public function show(TsumiageItem $item)
    {
        $this->authorize('view', $item);
        return new TsumiageItemResource($item);
    }
}
