<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'clientCode' => $this->clientCode,
            'clientName' => $this->clientName,
            'customer_id' => $this->customer_id,
            'serviceType' => $this->serviceType,
            'requestType' => $this->requestType,
            'changeReason' => $this->changeReason,
            'planFrom' => $this->planFrom,
            'totalFrom' => $this->totalFrom,
            'notes' => $this->notes,
            'total' => $this->total,
            'plan_id' => $this->plan_id,
            'createdBy_id' => $this->createdBy_id,
            'lastEditedBy_id' => $this->lastEditedBy_id,
            'lastEditedAt' => $this->lastEditedAt?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'plan' => new PlanResource($this->whenLoaded('plan')),
            'createdBy' => new UserResource($this->whenLoaded('createdBy')),
            'lastEditedBy' => new UserResource($this->whenLoaded('lastEditedBy')),
        ];
    }
}
