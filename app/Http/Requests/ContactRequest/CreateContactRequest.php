<?php

namespace App\Http\Requests\ContactRequest;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:contacts,email'],
            'phone' => ['required', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/']
        ];
    }
}
