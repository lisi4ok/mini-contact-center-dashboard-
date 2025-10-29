<?php

namespace App\Dto;

use App\Models\Contact;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

readonly class Interaction
{
    public function __construct(
        public Contact $contact,
        public string $type,
        public ?string $note = null,
        public \DateTimeInterface | CarbonInterface | string $timestamp,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            contact: Contact::findOrFail($data['contact_id']),
            type: $data['type'],
            note: $data['note'] ?? null,
            timestamp: self::parseTimestamp($data['timestamp']),
        );
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            contact: Contact::findOrFail($request->input('contact_id')),
            type: $request->input('type'),
            note: $request->input('note'),
            timestamp: self::parseTimestamp($request->input('timestamp')),
        );
    }

    private static function parseTimestamp(string $timestamp): CarbonInterface
    {
        return Carbon::parse($timestamp);
    }
}
