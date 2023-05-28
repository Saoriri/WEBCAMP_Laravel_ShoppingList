<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRegisterPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
    return [
        'name' => ['required', 'max:128'],
        'email' => ['required', 'max:254'],
        'password' => ['required', 'max:72'],
        'password_confirmation' => 'required|same:password',
    ];
    }
}