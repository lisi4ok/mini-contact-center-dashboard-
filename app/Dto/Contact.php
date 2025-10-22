<?php

namespace App\Dto;

use Illuminate\Http\Request;

readonly class Contact
{
    public function __construct(
        public string $name,
        public string $email,
        public int $phone,
        public ?string $company = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            company: $data['company'] ?? null,
        );
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            company: $request->input('company'),
        );
    }
}
