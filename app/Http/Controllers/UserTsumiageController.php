<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TsumiageCollection;

class UserTsumiageController extends Controller
{
    public function show(Request $request)
    {
        $tsumiages = Auth::user()->tsumiages->where('date', $request->data);
        return new TsumiageCollection($tsumiages);
    }

}
