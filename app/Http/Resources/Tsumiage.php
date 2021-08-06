<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Tsumiage extends JsonResource
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
                'type' => 'tsumiage',
                'tsumiage_id' => $this->id,
                'attributes'=> [
                    'item' => $this->item,
                    'plan_time' => $this->plan_time,
                    'actual_time' => $this->actual_time,
                ]
            ],
            'links' => [
                'self' => '/tsumiage/' . $this->id . '/edit',
            ]
        ];
    }
}
