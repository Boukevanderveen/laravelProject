<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateOrderAdressRequest extends FormRequest
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
            'name' => 'required|alpha|max:55',
            'company_name'=>'nullable|max:55',
            'street'=>'required|alpha|max:70',
            'house_number'=>'required|integer|max:19999',
            'addition'=>'nullable|alpha|max:5',
            'zipcode'=>'required|string:55|max:7',
            'city'=>'required|alpha|max:45',
            'phone_number'=>'required|numeric|max:999999999999999',
            'email'=>'required|email',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Het veld naam is verplicht',
            'name.alpha' => 'Het veld naam mag alleen letters bevatten',
            'name.max' => 'Het veld naam mag niet langer dan 55 letters zijn',
            'company_name.max' => 'Het veld bedrijfsnaam mag niet langer dan 55 letters zijn',
            'street.required' => 'Het veld straatnaam is verplicht',
            'street.alpha' => 'Het veld straatnaam mag alleen letters bevatten',
            'street.max' => 'Het veld straatnaam mag niet langer dan 70 letters zijn',
            'house_number.required' => 'Het veld huisnummer is verplicht',
            'house_number.integer' => 'Het veld huisnummer mag alleen cijfers bevatten',
            'house_number.max' => 'Het veld huisnummer mag niet groter zijn dan 19999 cijfers',
            'addition.required' => 'Het veld toevoeging is verplicht',
            'addition.alpha' => 'Het veld toevoeging is mag alleen letters bevatten',
            'addition.max' => 'Het veld toevoeging is mag niet langer dan 5 letters zijn',
            'zipcode.required' => 'Het veld postcode is verplicht',
            'zipcode.string' => 'Het veld postcode mag alleen letters bevatten',
            'zipcode.max' => 'Het veld postocde mag niet langer dan 7 karakters zijn',
            'city.required' => 'Het veld woonplaats is verplicht',
            'city.alpha' => 'Het veld woonplaats mag alleen letters bevatten',
            'city.max' => 'Het veld woonplaats mag niet meer dan 45 letters bevatten',
            'phone_number.required' => 'Het veld telefoon is verplicht',
            'phone_number.required' => 'Het veld telefoon is verplicht',
            'phone_number.numeric' => 'Het veld telefoon mag alleen cijfers bevatten',
            'phone_number.max' => 'Het veld telefoon mag niet meer dan 15 karakters bevatten',
            'email.email' => 'Het veld E-mail moet een E-mail zijn',
            'email.required' => 'Het veld E-mail is verplicht',
        ];
    }
}
