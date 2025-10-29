<?php

use App\Dto\Contact as ContactDto;
use App\Models\Contact as ContactModel;
use App\Services\ContactService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = new ContactService();
});

it('creates a contact', function () {
    $dto = new ContactDto(
        name: 'John Doe',
        email: 'john@example.com',
        phone: '+1-555-0001',
        company: 'Acme Inc'
    );

    $contact = $this->service->create($dto);

    expect($contact)->toBeInstanceOf(ContactModel::class)
        ->and($contact->name)->toBe('John Doe')
        ->and($contact->email)->toBe('john@example.com')
        ->and($contact->phone)->toBe('+1-555-0001')
        ->and($contact->company)->toBe('Acme Inc')
        ->and(ContactModel::count())->toBe(1);
});

it('gets all contacts', function () {
    ContactModel::query()->create([
        'name' => 'A',
        'email' => 'a@example.com',
        'phone' => '111',
        'company' => 'C1',
    ]);
    ContactModel::query()->create([
        'name' => 'B',
        'email' => 'b@example.com',
        'phone' => '222',
        'company' => 'C2',
    ]);

    $all = $this->service->getAll();

    expect($all)->toHaveCount(2);
});

it('gets a contact by id', function () {
    $c = ContactModel::query()->create([
        'name' => 'Jane',
        'email' => 'jane@example.com',
        'phone' => '333',
        'company' => 'C3',
    ]);

    $found = $this->service->getById($c->id);

    expect($found->id)->toBe($c->id);
});

it('throws when contact not found', function () {
    $this->service->getById(9999);
})->throws(ModelNotFoundException::class);

it('updates a contact', function () {
    $c = ContactModel::query()->create([
        'name' => 'Old',
        'email' => 'old@example.com',
        'phone' => '000',
        'company' => 'OldCo',
    ]);

    $dto = new ContactDto(
        name: 'New',
        email: 'new@example.com',
        phone: '999',
        company: 'NewCo'
    );

    $updated = $this->service->update($c->id, $dto);

    expect($updated->fresh()->only(['name','email','phone','company']))->toMatchArray([
        'name' => 'New',
        'email' => 'new@example.com',
        'phone' => '999',
        'company' => 'NewCo',
    ]);
});

it('deletes a contact', function () {
    $c = ContactModel::query()->create([
        'name' => 'Del',
        'email' => 'del@example.com',
        'phone' => '444',
        'company' => 'DelCo',
    ]);

    $result = $this->service->delete($c->id);

    expect($result)->toBeTrue()
        ->and(ContactModel::find($c->id))->toBeNull();
});

it('converts model to dto', function () {
    $c = ContactModel::query()->create([
        'name' => 'DTO',
        'email' => 'dto@example.com',
        'phone' => '555',
        'company' => 'DtoCo',
    ]);

    $dto = $this->service->convertToDto($c);

    expect($dto)->toBeInstanceOf(ContactDto::class)
        ->and($dto->name)->toBe('DTO')
        ->and($dto->email)->toBe('dto@example.com')
        ->and($dto->phone)->toBe('555')
        ->and($dto->company)->toBe('DtoCo');
});
