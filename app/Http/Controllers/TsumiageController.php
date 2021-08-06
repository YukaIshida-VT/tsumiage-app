<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tsumiage;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TsumiageCollection;
use App\Http\Requests\TsumiageRequest;
use App\Http\Resources\Tsumiage as TsumiageResource;

class TsumiageController extends Controller
{
    public function store(TsumiageRequest $request) 
    {
        $this->authorize('create', Tsumiage::class);

        $dataArray = [];

        for ($i = 1; $i <= 11; $i++) {
            $itemKey = 'item' . $i;
            $planTimeKey = 'plan_time' . $i;
            $actualTimeKey = 'actual_time' . $i;

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


    public function update(Request $request, Tsumiage $tsumiage)
    {
        info($request);
        // TODO バリデーションとポリシー追加
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

}
