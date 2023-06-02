<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::User()->isAdmin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:55'
        ];
    }

    public function messages(): array
    {
        return [
            
            'name.required' => 'De naam is verplicht',
            'name.min' => 'De naam moet minimaal 2 karakters bevatten',
            'name.max' => 'De naam mag niet meer dan 55 karakters bevatten',
        ];
    }
}
