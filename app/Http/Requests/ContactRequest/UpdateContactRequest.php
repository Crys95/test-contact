<?php

namespace App\Http\Requests\ContactRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    public function rules(): array
    {
        $contactId = $this->route('contact');
        
        return [
            'name' => ['sometimes', 'string', 'min:3'],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('contacts')->ignore($contactId)
            ],
            'phone' => ['sometimes', 'regex:/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/']
        ];
    }
}
