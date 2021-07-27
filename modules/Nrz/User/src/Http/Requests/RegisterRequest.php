<?php

namespace Nrz\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nrz\User\Rules\ValidPassword;

class RegisterRequest extends FormRequest
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
            "name"=>['required','string','max:250'],
            "email"=>['required','string','max:250','email','unique:users'],
            "password"=>['required', new ValidPassword(), 'confirmed']
        ];
    }
}
