<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required|max:95',
            'deadline' => 'required',
            'project' => 'required',
            'assigned_to' => 'required',
            'status' => 'required',
            'is_open' => 'required',
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
            
            'name.required' => 'Dit veld is verplicht',
            'name.max' => 'Dit veld mag niet langer zijn dan 25 letters',
            'description.required' => 'Dit veld is verplicht',
            'description.max' => 'Dit veld mag niet langer zijn dan 95 letters',
            'deadline.required' => 'Dit veld is verplicht',
            'project.required' => 'Dit veld is verplicht',
            'assigned_to.required' => 'Dit veld is verplicht',
            'status.required' => 'Dit veld is verplicht',
            'is_open.required' => 'Dit veld is verplicht',

        ];
    }
}
