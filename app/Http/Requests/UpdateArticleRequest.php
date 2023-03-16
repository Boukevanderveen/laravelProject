<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'title' => 'required|min:3',
            'category' => 'required',
            'image' => 'max:2048', 'nullable', 'mimes:jph,jpeg,png,png,gif',
            'published_at' => 'required',
            'description' => 'required|min:3', 
            'content' => 'required|min:2', 
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

            'title.required' => 'De titel is verplicht',
            'title.min' => 'De titel moet minimaal 3 letters bevatten',
            'description.required' => 'De beschrijving is verplicht',
            'description.min' => 'De beschrijving moet minimaal 3 letters bevatten',
            'content.required' => 'De content is verplicht',
            'content.min' => 'De content moet minimaal 2 letters bevatten',
            'category.required' => 'De categorie is verplicht',
            'published_at.required' => 'De publiseer datum is verplicht',
            'image.max' => 'De afbeelding mag niet groter dan 2MB bevatten',
        ];
    }
}
