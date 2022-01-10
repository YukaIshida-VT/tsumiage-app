<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbstracWeight extends FormRequest
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
        return [
            'weight' => 'required|numeric|digits_between:1,4',
            'breakfast_calories' => 'nullable|numeric',
            'lunch_calories' => 'nullable|numeric',
            'supper_calories' => 'nullable|numeric',
            'snack_calories' => 'nullable|numeric',
            'total_calories' => 'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'weight' => '体重',
            'breakfast_calories' => '朝食のカロリー',
            'lunch_calories' => '昼食のカロリー',
            'supper_calories' => '晩飯のカロリー',
            'snack_calories' => '間食のカロリー',
            'total_calories' => 'トータルカロリー',
        ];
    }
}
