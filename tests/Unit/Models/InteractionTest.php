<?php

use App\Models\Contact;
use App\Models\Interaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an interaction via factory', function () {
    $contact = Contact::factory()->create();

    $interaction = Interaction::factory()->create([
        'contact_id' => $contact->id,
        'type' => 'call',
        'note' => 'Follow-up call',
        'timestamp' => now()->toDateTimeString(),
    ]);

    expect($interaction)->toBeInstanceOf(Interaction::class)
        ->and($interaction->exists)->toBeTrue()
        ->and($interaction->contact_id)->toBe($contact->id)
        ->and($interaction->type)->toBe('call');
});

it('exposes the expected fillable attributes', function () {
    $interaction = new Interaction();

    expect($interaction->getFillable())->toEqual([
        'contact_id',
        'type',
        'note',
        'timestamp',
    ]);
});

it('belongs to a contact', function () {
    $contact = Contact::factory()->create();

    $interaction = Interaction::factory()->create([
        'contact_id' => $contact->id,
    ]);

    $interaction->load('contact');

    expect($interaction->contact)->toBeInstanceOf(Contact::class)
        ->and($interaction->contact->is($contact))->toBeTrue();
});
