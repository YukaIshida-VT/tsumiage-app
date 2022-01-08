<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Weight extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'weight',
                'weight_id' => $this->id,
                'attributes'=> [
                    'weight' => $this->weight,
                    'breakfast' => $this->breakfast,
                    'lunch' => $this->lunch,
                    'supper' => $this->supper,
                    'snack' => $this->snack,
                    'breakfast_calories' => $this->breakfast_calories,
                    'lunch_calories' => $this->lunch_calories,
                    'supper_calories' => $this->supper_calories,
                    'snack_calories' => $this->snack_calories,
                    'total_calories' => $this->total_calories,
                ]
            ],
            'links' => [
                'self' => '/weight/' . $this->id . '/edit',
            ]
        ];
    }
}
