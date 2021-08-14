<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tsumiage;
use Illuminate\Http\Response;
use App\Http\Resources\TsumiageCollection;
use App\Http\Requests\StoreTsumiage;
use App\Http\Requests\UpdateTsumiage;
use App\Http\Resources\Tsumiage as TsumiageResource;

class TsumiageController extends Controller
{
    public function store(StoreTsumiage $request) 
    {
        $this->authorize('create', Tsumiage::class);

        $dataArray = [];

        for ($i = 1; $i <= 11; $i++) {
            $itemKey = 'add_item' . $i;
            $planTimeKey = 'add_plan_time' . $i;
            $actualTimeKey = 'add_actual_time' . $i;

            if ($request->has($itemKey)) {
                $dataArray[] = ['item' => $request->$itemKey, 'plan_time' => $request->$planTimeKey,
                                 'actual_time' => $request->$actualTimeKey, 'date' => $request->date];
            }
        }
        $tsumiages = request()->user()->tsumiages()->createMany($dataArray);

        return (new TsumiageCollection($tsumiages))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }


    public function update(UpdateTsumiage $request, Tsumiage $tsumiage)
    {
        $this->authorize('update', $tsumiage);
        $itemKey = 'item' . $request->key;
        $planTimeKey = 'plan_time' . $request->key;
        $actualTimeKey = 'actual_time' . $request->key;

        $tsumiage->update([
            'item' => $request->$itemKey,
            'plan_time' => $request->$planTimeKey,
            'actual_time' => $request->$actualTimeKey,
        ]);

        return (new TsumiageResource($tsumiage))
        ->response()
        ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Tsumiage $tsumiage)
    {
        $this->authorize('delete', $tsumiage);
        $tsumiage->delete();
        return response([], Response::HTTP_NO_CONTENT); 
    }

}
