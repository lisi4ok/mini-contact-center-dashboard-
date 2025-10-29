<?php

namespace App\Actions\Interaction;

trait InteractionValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_id' => ['required', 'numeric', 'exists:contacts,id'],
            'type' => ['required', 'in:click,hover,scroll,keyboard,swipe'],
            'note' => ['nullable', 'string'],
        ];
    }
}
