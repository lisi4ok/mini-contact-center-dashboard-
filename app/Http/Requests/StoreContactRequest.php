<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Contact\ContactValidationRules;

class StoreContactRequest extends FormRequest
{
    use ContactValidationRules;
}
