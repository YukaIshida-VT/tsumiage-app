<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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

        for ($i = 1; $i <= 21; $i++) {
            $key = 'item' . $i;
            if (array_key_exists($key, $data)) {
                $returnArray[$key] = 'required';
            }
        }

        return $returnArray;
    }
}
