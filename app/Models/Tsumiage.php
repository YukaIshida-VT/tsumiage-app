<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tsumiage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function get_tsumiage_sum($user_id, $start_day, $end_day)
    {
        $tsumiages = self::where('user_id', $user_id)->whereBetween('date', [$start_day, $end_day])->get();
        $returnArray = [];
        
        foreach($tsumiages as $tsmiage) {
            if (isset($returnArray[$tsmiage->item])) {
                $returnArray[$tsmiage->item] += $tsmiage->actual_time;
            } else {
                $returnArray[$tsmiage->item] = $tsmiage->actual_time;
            }
        }

        return $returnArray;
    }
}
