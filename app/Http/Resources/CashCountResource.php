<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashCountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'coin_050' => $this->coin_050,
            'coin_1' => $this->coin_1,
            'coin_2' => $this->coin_2,
            'coin_5' => $this->coin_5,
            'bill_10' => $this->bill_10,
            'bill_20' => $this->bill_20,
            'bill_50' => $this->bill_50,
            'bill_100' => $this->bill_100,
            'bill_200' => $this->bill_200,
            'total' => $this->total,
            'createdBy_id' => $this->createdBy_id,
            'createdBy' => new UserResource($this->whenLoaded('createdBy')),
        ];
    }
}
