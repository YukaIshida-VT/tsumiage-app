<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsumiageItem extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getItemNum($id)
    {
        $record = self::where('id', $id)->first();
        $item_num = 0;

        for ($i = 1; $i <= 21; $i++) {
            $key = 'item' . $i;
            if (! is_null($record->$key)) {
                $item_num += 1;
            }
        }

        return $item_num;
    }
}
