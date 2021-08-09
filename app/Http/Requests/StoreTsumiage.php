<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTsumiage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->all();

        $returnArray = [];

        for ($i = 1; $i <= 11; $i++) {
            $itemKey = 'add_item' . $i;
            $planTimeKey = 'add_plan_time' . $i;
            $actualTimeKey = 'add_actual_time' . $i;
            if (array_key_exists($itemKey, $data)) {
                $returnArray[$itemKey] = 'required';
                $returnArray[$planTimeKey] = 'nullable|numeric';
                $returnArray[$actualTimeKey] = 'nullable|numeric';
            }
        }

        return $returnArray;
    }

    public function attributes()
    {
        $returnArray = [];

        for ($i = 1; $i <= 11; $i++) {
            $itemKey = 'add_item' . $i;
            $planTimeKey = 'add_plan_time' . $i;
            $actualTimeKey = 'add_actual_time' . $i;

            $returnArray[$itemKey] = '積み上げ';
            $returnArray[$planTimeKey] = '予定時間';
            $returnArray[$actualTimeKey] = '実績時間';
        }

        return $returnArray;
    }
}
