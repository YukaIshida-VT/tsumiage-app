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
                    '1' => $this->item1,
                    '2' => $this->item2,
                    '3' => $this->item3,
                    '4' => $this->item4,
                    '5' => $this->item5,
                    '6' => $this->item6,
                    '7' => $this->item7,
                    '8' => $this->item8,
                    '9' => $this->item9,
                    '10' => $this->item10,
                    '11' => $this->item11,
                    '12' => $this->item12,
                    '13' => $this->item13,
                    '14' => $this->item14,
                    '15' => $this->item15,
                    '16' => $this->item16,
                    '17' => $this->item17,
                    '18' => $this->item18,
                    '19' => $this->item19,
                    '20' => $this->item20,
                    'dummy' => 'dummy'
                ]
            ],
            'links' => [
                'self' => '/items/' . $this->id . '/edit',
            ]
        ];
    }
}
