<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterProductPriceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //'min_price' => 'max:10',
            'max_price' => 'required_with:min_value'
        ];
    }

    public function messages(): array
    {
        return [
            'max_price.required_with' => 'Het veld maximum prijs is verplicht ',
        ];
    }
}
