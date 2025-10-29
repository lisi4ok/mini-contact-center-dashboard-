<?php

namespace App\Services;

use App\Models\Interaction as InteractionModel;
use App\Dto\Interaction as InteractionDto;
use Illuminate\Database\Eloquent\Collection;

class InteractionService
{
    public function getAll(): Collection
    {
        return InteractionModel::all();
    }

    public function create(InteractionDto $dto): InteractionModel
    {
        return InteractionModel::create([
            'contact_id' => $dto->contact->id,
            'type' => $dto->type,
            'timestamp' => $dto->timestamp,
            'note' => $dto->note,
        ]);
    }

    public function getById(int $id): InteractionModel
    {
        return InteractionModel::findOrFail($id);
    }

    public function update(int $id, InteractionDto $dto): InteractionModel
    {
        $interaction = InteractionModel::findOrFail($id);

        $interaction->update([
            'contact_id' => $dto->contact->id,
            'type' => $dto->type,
            'timestamp' => $dto->timestamp,
            'note' => $dto->note,
        ]);

        return $interaction;
    }

    public function delete(int $id): bool
    {
        return InteractionModel::findOrFail($id)->delete();
    }

    public function convertToDto(InteractionModel $interaction): InteractionDto
    {
        return new InteractionDto(
            contact: $interaction->contact,
            type: $interaction->type,
            note: $interaction->note,
            timestamp: $interaction->timestamp,
        );
    }
}
