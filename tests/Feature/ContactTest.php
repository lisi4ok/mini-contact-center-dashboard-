<?php

use App\Models\Contact;
use App\Models\Interaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('displays contacts index page', function () {
    Contact::factory()->count(3)->create();

    $response = $this->get(route('contacts.index'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('contacts/index')
            ->has('contacts', 3)
        );
});

it('displays contact create page', function () {
    $response = $this->get(route('contacts.create'));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page->component('contacts/create'));
});

it('stores a new contact', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '+359887422009',
        'company' => 'Acme Inc',
    ];

    $response = $this->post(route('contacts.store'), $data);

    $response->assertRedirect(route('contacts.index'));

    $this->assertDatabaseHas('contacts', ['email' => 'john@example.com']);
});

it('displays contact details', function () {
    $contact = Contact::factory()->create();
    Interaction::factory()->count(2)->create(['contact_id' => $contact->id]);

    $response = $this->get(route('contacts.show', $contact));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('contacts/show')
            ->has('contact')
            ->has('interactions', 2)
        );
});

it('displays contact edit page', function () {
    $contact = Contact::factory()->create();

    $response = $this->get(route('contacts.edit', $contact));

    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('contacts/edit')
            ->has('contact')
        );
});

it('updates a contact', function () {
    $contact = Contact::factory()->create();
    $data = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'phone' => '+359887422009',
        'company' => $contact->company,
    ];

    $response = $this->put(route('contacts.update', $contact), $data);

    $response->assertRedirect(route('contacts.index'));

    $this->assertDatabaseHas('contacts', ['email' => 'updated@example.com']);
});

it('deletes a contact', function () {
    $contact = Contact::factory()->create();

    $response = $this->delete(route('contacts.destroy', $contact));

    $response->assertRedirect(route('contacts.index'));

    $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
});

it('handles store validation errors', function () {
    $response = $this->post(route('contacts.store'), []);

    $response->assertSessionHasErrors(['name', 'email']);
});

it('handles update validation errors', function () {
    $contact = Contact::factory()->create();

    $response = $this->put(route('contacts.update', $contact), [
        'email' => 'invalid-email',
    ]);

    $response->assertSessionHasErrors('email');
});
