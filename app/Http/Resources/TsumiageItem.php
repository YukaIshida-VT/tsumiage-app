<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TsumiageItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'tsumiage-item',
                'tsumiage_item_id' => $this->id,
                'attributes'=> [
                    'item1' => $this->item1,
                    'item2' => $this->item2,
                    'item3' => $this->item3,
                    'item4' => $this->item4,
                    'item5' => $this->item5,
                    'item6' => $this->item6,
                    'item7' => $this->item7,
                    'item8' => $this->item8,
                    'item9' => $this->item9,
                    'item10' => $this->item10,
                    'item11' => $this->item11,
                    'item12' => $this->item12,
                    'item13' => $this->item13,
                    'item14' => $this->item14,
                    'item15' => $this->item15,
                    'item16' => $this->item16,
                    'item17' => $this->item17,
                    'item18' => $this->item18,
                    'item19' => $this->item19,
                    'item20' => $this->item20,
                ]
            ],
            'links' => [
                'self' => url('/users/' . $this->user_id),
            ]
        ];
    }
}
