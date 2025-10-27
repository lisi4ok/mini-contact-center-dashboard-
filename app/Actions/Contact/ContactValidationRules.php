<?php

namespace App\Actions\Contact;

trait ContactValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
            ],
            'phone' => [
                'required',
                'phone:' . config('app.phone_countries'),
            ],
            'company' => ['nullable', 'string', 'max:255'],
//            'interactions' => ['nullable', 'array'],
//            'interactions.type' => ['nullable', 'in:click,hover,scroll,keyboard,swipe'],
//            'interactions.note' => ['nullable', 'string'],
        ];
    }
}
