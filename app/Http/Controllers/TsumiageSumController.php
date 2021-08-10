<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tsumiage;
use Illuminate\Support\Facades\Auth;

class TsumiageSumController extends Controller
{
    public function show(Request $request)
    {
        $yyyymmdd = $request->yyyymmdd;
        $ymd_time = strtotime($yyyymmdd);
        $week_num = date("N", $ymd_time);

        if ($week_num == 1){
            //月曜日だった場合
            $monday = date('Y-m-d', $ymd_time);
        }else{
            $days_from_monday = $week_num - 1;
            $monday = date('Y-m-d', strtotime("-{$days_from_monday} day", $ymd_time));
        }
        $sunday = date('Y-m-d', strtotime("+6 day", strtotime($monday)));

        $month = date('Y-m', $ymd_time);
        // 月の初日
        $firstDate = date('Y-m-d', strtotime('first day of ' . $month));
        // 月の最終日
        $lastDate = date('Y-m-d', strtotime('last day of ' . $month));

        $returnArray = [
            'weekly_tsumiage_sum' => Tsumiage::get_tsumiage_sum(Auth::user()->id, $monday, $sunday),
            'monthly_tsumiage_sum' => Tsumiage::get_tsumiage_sum(Auth::user()->id, $firstDate, $lastDate),
        ];

        return json_encode($returnArray);
    }
}
