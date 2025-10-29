<?php

namespace App\Services;

use App\Models\Contact as ContactModel;
use App\Dto\Contact as ContactDto;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    public function getAll(): Collection
    {
        return ContactModel::all();
    }

    public function create(ContactDto $dto): ContactModel
    {
        return ContactModel::create([
            'name'  => $dto->name,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'company' => $dto->company,
        ]);
    }

    public function getById(int $id): ContactModel
    {
        return ContactModel::findOrFail($id);
    }

    public function update(int $id, ContactDto $dto): ContactModel
    {
        $contact = ContactModel::findOrFail($id);

        $contact->update([
            'name'  => $dto->name,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'company' => $dto->company,
        ]);

        return $contact;
    }

    public function delete(int $id): bool
    {
        return ContactModel::findOrFail($id)->delete();
    }

    public function convertToDto(ContactModel $contact): ContactDto
    {
        return new ContactDto(
            name: $contact->name,
            email: $contact->email,
            phone: $contact->phone,
            company: $contact->company,
        );
    }
}
