<?php

namespace App\Http\Requests\ContactRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:contacts,email'],
            'phone' => ['required', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/']
        ];
    }
}
