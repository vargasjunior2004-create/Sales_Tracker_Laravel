<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanPublicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'label' => $this->label,
            'type' => $this->type,
            'speed' => $this->speed,
            'monthly' => $this->monthly,
            'installation' => $this->installation,
            'total' => $this->total,
        ];
    }
}
