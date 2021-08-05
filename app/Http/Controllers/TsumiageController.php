<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tsumiage;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TsumiageCollection;

class TsumiageController extends Controller
{
    public function store(Request $request) 
    {
        $this->authorize('create', Tsumiage::class);
        $tsumiages = request()->user()->tsumiages()->createMany($request->tsumiage);
        info($tsumiages);

        return (new TsumiageCollection($tsumiages))
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }

}
