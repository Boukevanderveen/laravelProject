<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateProductAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:55|unique:product_attributes,name,' . $this->route('attribute')->id . ',id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'De naam is verplicht',
            'name.min' => 'De naam moet minimaal 2 karakters bevatten',
            'name.max' => 'De naam mag niet meer dan 55 karakters bevatten',
            'name.unique' => 'Er is al een product eigenschap met deze naam',
        ];
    }
}
