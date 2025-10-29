<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Contact\InteractionValidationRules;

class UpdateInteractionRequest extends FormRequest
{
    use InteractionValidationRules;
}
