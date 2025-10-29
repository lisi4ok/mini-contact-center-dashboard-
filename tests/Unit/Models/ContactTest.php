<?php

use App\Models\Contact;
use App\Models\Interaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a contact via factory', function () {
    $contact = Contact::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.test',
        'phone' => '123456789',
        'company' => 'Acme Inc',
    ]);

    expect($contact)->toBeInstanceOf(Contact::class)
        ->and($contact->exists)->toBeTrue()
        ->and($contact->name)->toBe('John Doe');
});

it('exposes the expected fillable attributes', function () {
    $contact = new Contact();

    expect($contact->getFillable())->toEqual([
        'name',
        'email',
        'phone',
        'company',
    ]);
});

it('has many interactions', function () {
    $contact = Contact::factory()->create();

    Interaction::factory()->count(2)->create([
        'contact_id' => $contact->id,
    ]);

    $contact->load('interactions');

    expect($contact->interactions)->toHaveCount(2)
        ->and($contact->interactions->first())->toBeInstanceOf(Interaction::class);
});
