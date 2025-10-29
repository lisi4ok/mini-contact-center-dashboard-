
<?php

use App\Models\Contact;
use App\Models\Interaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

describe('index', function () {
    it('displays the interactions index page', function () {
        $contact = Contact::factory()->create();
        Interaction::factory()->count(3)->create(['contact_id' => $contact->id]);

        get(route('interactions.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('interactions/index')
                ->has('interactions', 3)
            );
    });

    it('shows empty list when no interactions exist', function () {
        get(route('interactions.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('interactions/index')
                ->has('interactions', 0)
            );
    });
});

describe('create', function () {
    it('displays the create interaction form', function () {
        $contacts = Contact::factory()->count(2)->create();

        get(route('interactions.create'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('interactions/create')
                ->has('contacts', 2)
            );
    });
});

describe('store', function () {
    it('creates a new interaction with valid data', function () {
        $contact = Contact::factory()->create();

        $data = [
            'contact_id' => $contact->id,
            'type' => 'click',
            'note' => 'Test interaction note',
        ];

        post(route('interactions.store'), $data)
            ->assertRedirect(route('interactions.index'))
            ->assertSessionHas('success', 'Interaction created successfully.');

        assertDatabaseHas('interactions', [
            'contact_id' => $contact->id,
            'type' => 'click',
            'note' => 'Test interaction note',
        ]);
    });

    it('fails to create interaction with invalid contact_id', function () {
        $data = [
            'contact_id' => 999,
            'type' => 'click',
            'note' => 'Test note',
        ];

        post(route('interactions.store'), $data)
            ->assertSessionHasErrors('contact_id');
    });

    it('requires contact_id field', function () {
        $data = [
            'type' => 'click',
            'note' => 'Test note',
        ];

        post(route('interactions.store'), $data)
            ->assertSessionHasErrors('contact_id');
    });

    it('requires type field', function () {
        $contact = Contact::factory()->create();

        $data = [
            'contact_id' => $contact->id,
            'note' => 'Test note',
        ];

        post(route('interactions.store'), $data)
            ->assertSessionHasErrors('type');
    });

    it('validates type field must be valid enum value', function () {
        $contact = Contact::factory()->create();

        $data = [
            'contact_id' => $contact->id,
            'type' => 'invalid_type',
            'note' => 'Test note',
        ];

        post(route('interactions.store'), $data)
            ->assertSessionHasErrors('type');
    });
});

describe('show', function () {
    it('displays a single interaction', function () {
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        get(route('interactions.show', $interaction))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('interactions/show')
                ->has('interaction')
                ->has('contacts')
            );
    });
});

describe('edit', function () {
    it('displays the edit interaction form', function () {
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        get(route('interactions.edit', $interaction))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('interactions/edit')
                ->has('interaction')
                ->has('contacts')
            );
    });
});

describe('update', function () {
    it('updates an existing interaction with valid data', function () {
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        $newContact = Contact::factory()->create();
        $data = [
            'contact_id' => $newContact->id,
            'type' => 'hover',
            'note' => 'Updated note',
        ];

        put(route('interactions.update', $interaction), $data)
            ->assertRedirect(route('interactions.index'))
            ->assertSessionHas('success', 'Interaction updated successfully.');

        assertDatabaseHas('interactions', [
            'id' => $interaction->id,
            'contact_id' => $newContact->id,
            'type' => 'hover',
            'note' => 'Updated note',
        ]);
    });

    it('fails to update interaction with invalid contact_id', function () {
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        $data = [
            'contact_id' => 999,
            'type' => 'hover',
            'note' => 'Updated note',
        ];

        put(route('interactions.update', $interaction), $data)
            ->assertSessionHasErrors('contact_id');
    });

    it('validates type field during update', function () {
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        $data = [
            'contact_id' => $contact->id,
            'type' => 'invalid_type',
            'note' => 'Updated note',
        ];

        put(route('interactions.update', $interaction), $data)
            ->assertSessionHasErrors('type');
    });

    it('handles not found exception during update', function () {
        $contact = Contact::factory()->create();

        put(route('interactions.update', 999999), [
            'contact_id' => $contact->id,
            'type' => 'hover',
            'note' => 'Updated note',
        ])
            ->assertRedirect()
            ->assertSessionHas('error', 'Failed to update Interaction');
    });
});

describe('destroy', function () {
    it('deletes an existing interaction', function () {
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        delete(route('interactions.destroy', $interaction))
            ->assertRedirect(route('interactions.index'))
            ->assertSessionHas('success', 'Interaction deleted successfully.');

        assertDatabaseMissing('interactions', [
            'id' => $interaction->id,
        ]);
    });

    it('handles not found exception during delete', function () {
        delete(route('interactions.destroy', 999999))
            ->assertRedirect()
            ->assertSessionHas('error', 'Failed to delete Interaction');
    });
});

describe('authorization', function () {
    it('requires authentication to access index', function () {
        auth()->logout();

        get(route('interactions.index'))
            ->assertRedirect(route('login'));
    });

    it('requires authentication to create interaction', function () {
        auth()->logout();

        get(route('interactions.create'))
            ->assertRedirect(route('login'));
    });

    it('requires authentication to store interaction', function () {
        auth()->logout();
        $contact = Contact::factory()->create();

        post(route('interactions.store'), [
            'contact_id' => $contact->id,
            'type' => 'click',
            'note' => 'Test note',
        ])
            ->assertRedirect(route('login'));
    });

    it('requires authentication to view interaction', function () {
        auth()->logout();
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        get(route('interactions.show', $interaction))
            ->assertRedirect(route('login'));
    });

    it('requires authentication to edit interaction', function () {
        auth()->logout();
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        get(route('interactions.edit', $interaction))
            ->assertRedirect(route('login'));
    });

    it('requires authentication to update interaction', function () {
        auth()->logout();
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        put(route('interactions.update', $interaction), [
            'contact_id' => $contact->id,
            'type' => 'hover',
            'note' => 'Updated note',
        ])
            ->assertRedirect(route('login'));
    });

    it('requires authentication to delete interaction', function () {
        auth()->logout();
        $contact = Contact::factory()->create();
        $interaction = Interaction::factory()->create(['contact_id' => $contact->id]);

        delete(route('interactions.destroy', $interaction))
            ->assertRedirect(route('login'));
    });
});
