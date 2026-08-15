<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OutflowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'personName' => $this->personName,
            'amount' => $this->amount,
            'concept' => $this->concept,
            'createdBy_id' => $this->createdBy_id,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
