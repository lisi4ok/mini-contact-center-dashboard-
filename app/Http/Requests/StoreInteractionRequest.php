<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Interaction\InteractionValidationRules;

class StoreInteractionRequest extends FormRequest
{
    use InteractionValidationRules;
}
