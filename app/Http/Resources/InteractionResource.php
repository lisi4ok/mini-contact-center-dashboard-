<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InteractionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            //'id' => $this->id,
            'contact' => $this->contact ?? null,
            'type' => $this->type,
            'timestamp' => $this->timestamp,
            'note' => $this->note ?? null,
        ];
    }
}
