<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\Weight as WeightResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Weight;
use App\Http\Requests\StoreWeight;
use App\Http\Requests\UpdateWeight;

class WeightController extends Controller
{
    public function show(Request $request)
    {
        $weight = Auth::user()->weights->where('date', $request->date)->first();

        if($weight) {
            return new WeightResource($weight);
        } else {
            return false;
        }
    }

    public function store(StoreWeight $request) 
    {
        info($request);
        $this->authorize('create', Weight::class);

        $dataArray = [];
        $dataArray = [
            'date' => $request->date, 
            'weight' => $request->weight,
            'breakfast' => $request->breakfast, 
            'lunch' => $request->lunch, 
            'supper' => $request->supper,
            'snack' => $request->snack,
            'breakfast_calories' => $request->breakfast_calories, 
            'lunch_calories' => $request->lunch_calories, 
            'supper_calories' => $request->supper_calories,
            'snack_calories' => $request->snack_calories,
            'total_calories' => $request->total_calories,
        ];

        $weight = request()->user()->weights()->create($dataArray);

        return (new WeightResource($weight))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateWeight $request, Weight $weight)
    {
        $this->authorize('update', $weight);

        $weight->update([
            'weight' => $request->weight,
            'breakfast' => $request->breakfast, 
            'lunch' => $request->lunch, 
            'supper' => $request->supper,
            'snack' => $request->snack,
            'breakfast_calories' => $request->breakfast_calories, 
            'lunch_calories' => $request->lunch_calories, 
            'supper_calories' => $request->supper_calories,
            'snack_calories' => $request->snack_calories,
            'total_calories' => $request->total_calories,
        ]);

        return (new WeightResource($weight))
        ->response()
        ->setStatusCode(Response::HTTP_OK);
    }
}
