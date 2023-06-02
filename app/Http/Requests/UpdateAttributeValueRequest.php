<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateAttributeValueRequest extends FormRequest
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
            "attributeValues.*"  => "nullable|max:55",
        ];
        
    }

    public function messages(): array
    {
        return [
            
            'attributeValues.*.max' => 'Dit veld mag niet meer dan 55 karakters bevatten',
        ];
    }
}
