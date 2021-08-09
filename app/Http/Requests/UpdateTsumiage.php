<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTsumiage extends FormRequest
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
        $returnArray = [];

        $key = $this->key;
        $itemKey = 'item' . $key;
        $planTimeKey = 'plan_time' . $key;
        $actualTimeKey = 'actual_time' . $key;

        $returnArray[$itemKey] = 'required';
        $returnArray[$planTimeKey] = 'nullable|numeric';
        $returnArray[$actualTimeKey] = 'nullable|numeric';

        return $returnArray;
    }

    public function attributes()
    {
        $returnArray = [];

        $key = $this->key;
        $itemKey = 'item' . $key;
        $planTimeKey = 'plan_time' . $key;
        $actualTimeKey = 'actual_time' . $key;

        $returnArray[$itemKey] = '積み上げ';
        $returnArray[$planTimeKey] = '予定時間';
        $returnArray[$actualTimeKey] = '実績時間';

        return $returnArray;
    }
}
