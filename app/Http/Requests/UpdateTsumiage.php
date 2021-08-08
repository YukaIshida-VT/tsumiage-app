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
        $data = $this->all();

        $returnArray = [];

        $key = $data['key'];
        $itemKey = 'item' . $key;
        $planTimeKey = 'plan_time' . $key;
        $actualTimeKey = 'actual_time' . $key;

        $returnArray[$itemKey] = 'required';
        $returnArray[$planTimeKey] = 'nullable|numeric';
        $returnArray[$actualTimeKey] = 'nullable|numeric';

        return $returnArray;
    }
}
