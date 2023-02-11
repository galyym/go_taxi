<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "email" => "required_without_all:phone|email|exists:users,email",
            "phone" => "required_without_all:email|numeric|exists:users,phone_number",
            "name" => "required_without_all:verification_code|string|exists:users,name",
            "verification_code" => "required_without_all:name|string|max:4",
        ];
    }
}
