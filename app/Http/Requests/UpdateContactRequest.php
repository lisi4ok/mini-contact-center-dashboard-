<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Actions\Contact\ContactValidationRules;

class UpdateContactRequest extends FormRequest
{
    use ContactValidationRules;
}
