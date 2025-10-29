<?php

use App\Dto\Interaction as InteractionDto;
use App\Models\Contact as ContactModel;
use App\Models\Interaction as InteractionModel;
use App\Services\InteractionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = new InteractionService();
});

it('creates an interaction', function () {
    $contact = ContactModel::query()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '111',
        'company' => 'Acme',
    ]);

    $dto = new InteractionDto(
        contact: $contact,
        type: 'email',
        timestamp: '2025-01-01 12:00:00',
        note: 'Intro email'
    );

    $interaction = $this->service->create($dto);

    expect($interaction)->toBeInstanceOf(InteractionModel::class)
        ->and($interaction->contact_id)->toBe($contact->id)
        ->and($interaction->type)->toBe('email')
        ->and($interaction->timestamp)->toBe('2025-01-01 12:00:00')
        ->and($interaction->note)->toBe('Intro email')
        ->and(InteractionModel::count())->toBe(1);
});

it('gets all interactions', function () {
    $c1 = ContactModel::query()->create([
        'name' => 'A',
        'email' => 'a@example.com',
        'phone' => '111',
        'company' => 'C1',
    ]);
    $c2 = ContactModel::query()->create([
        'name' => 'B',
        'email' => 'b@example.com',
        'phone' => '222',
        'company' => 'C2',
    ]);

    InteractionModel::query()->create([
        'contact_id' => $c1->id,
        'type' => 'call',
        'timestamp' => '2025-02-01 10:00:00',
        'note' => 'Called A',
    ]);
    InteractionModel::query()->create([
        'contact_id' => $c2->id,
        'type' => 'meeting',
        'timestamp' => '2025-02-02 11:00:00',
        'note' => 'Met B',
    ]);

    $all = $this->service->getAll();

    expect($all)->toHaveCount(2);
});

it('gets an interaction by id', function () {
    $contact = ContactModel::query()->create([
        'name' => 'Jane',
        'email' => 'jane@example.com',
        'phone' => '333',
        'company' => 'C3',
    ]);

    $i = InteractionModel::query()->create([
        'contact_id' => $contact->id,
        'type' => 'email',
        'timestamp' => '2025-03-01 09:00:00',
        'note' => 'Follow-up',
    ]);

    $found = $this->service->getById($i->id);

    expect($found->id)->toBe($i->id);
});

it('throws when interaction not found', function () {
    $this->service->getById(9999);
})->throws(ModelNotFoundException::class);

it('updates an interaction', function () {
    $cOld = ContactModel::query()->create([
        'name' => 'Old',
        'email' => 'old@example.com',
        'phone' => '000',
        'company' => 'OldCo',
    ]);
    $cNew = ContactModel::query()->create([
        'name' => 'New',
        'email' => 'new@example.com',
        'phone' => '999',
        'company' => 'NewCo',
    ]);

    $i = InteractionModel::query()->create([
        'contact_id' => $cOld->id,
        'type' => 'email',
        'timestamp' => '2025-04-01 08:00:00',
        'note' => 'Old note',
    ]);

    $dto = new InteractionDto(
        contact: $cNew,
        type: 'call',
        timestamp: '2025-04-02 14:30:00',
        note: 'Updated note'
    );

    $updated = $this->service->update($i->id, $dto);

    expect($updated->fresh()->only(['contact_id','type','timestamp','note']))->toMatchArray([
        'contact_id' => $cNew->id,
        'type' => 'call',
        'timestamp' => '2025-04-02 14:30:00',
        'note' => 'Updated note',
    ]);
});

it('deletes an interaction', function () {
    $contact = ContactModel::query()->create([
        'name' => 'Del',
        'email' => 'del@example.com',
        'phone' => '444',
        'company' => 'DelCo',
    ]);

    $i = InteractionModel::query()->create([
        'contact_id' => $contact->id,
        'type' => 'meeting',
        'timestamp' => '2025-05-01 15:00:00',
        'note' => 'To delete',
    ]);

    $result = $this->service->delete($i->id);

    expect($result)->toBeTrue()
        ->and(InteractionModel::find($i->id))->toBeNull();
});

it('converts model to dto', function () {
    $contact = ContactModel::query()->create([
        'name' => 'DTO',
        'email' => 'dto@example.com',
        'phone' => '555',
        'company' => 'DtoCo',
    ]);

    $i = InteractionModel::query()->create([
        'contact_id' => $contact->id,
        'type' => 'email',
        'timestamp' => '2025-06-01 16:00:00',
        'note' => 'DTO note',
    ]);

    $dto = $this->service->convertToDto($i);

    expect($dto)->toBeInstanceOf(InteractionDto::class)
        ->and($dto->contact->id)->toBe($contact->id)
        ->and($dto->type)->toBe('email')
        ->and($dto->timestamp)->toBe('2025-06-01 16:00:00')
        ->and($dto->note)->toBe('DTO note');
});
