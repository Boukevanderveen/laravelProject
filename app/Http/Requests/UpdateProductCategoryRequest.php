<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateProductCategoryRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:55|unique:product_categories,name,' . $this->route('category')->id . ',id',
        ];
    }

                /** 
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            
            'name.required' => 'De naam is verplicht',
            'name.min' => 'De naam moet minimaal 2 karakters bevatten',
            'name.max' => 'De naam mag niet meer dan 55 karakters bevatten',
            'name.unique' => 'Er is al een project categorie met deze naam',

        ];
    }
}
