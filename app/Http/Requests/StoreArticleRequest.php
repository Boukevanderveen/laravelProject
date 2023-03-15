<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
        $Articles->title = $request->title;
        $Articles->description = $request->description;
        $Articles->content = $request->content;
        $Articles->author = Auth::user()->name;
        $Articles->category = $request->category;
        $Articles->published_at = $request->published_at;

        return [
            'title' => 'required|min:3',
            'description' => 'required|min:3', 
            'content' => 'required', 
            'çategory' => 'required',
            'image' => 'nullable', 'mimes:jph,jpeg,png,png,gif','max:2048'
        ];
    }
}
