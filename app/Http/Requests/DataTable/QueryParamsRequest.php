<?php

namespace App\Http\Requests\DataTable;

use App\Enums\Sort;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QueryParamsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search'  => ['nullable', 'string'],
            'limit'   => ['nullable', 'integer'],
            'column'  => ['nullable', 'string'],
            'sort'    => ['nullable', Rule::enum(Sort::class)],
            'filters' => ['nullable', 'array'],
        ];
    }
}
