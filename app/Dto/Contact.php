<?php

namespace App\Dto;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

readonly class Contact
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public ?string $company = null,
        public null|array|Collection $interactions = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            company: $data['company'] ?? null,
            interactions: $data['interactions'] ?? null,
        );
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            company: $request->input('company'),
            interactions: $request->input('interactions'),
        );
    }
}
