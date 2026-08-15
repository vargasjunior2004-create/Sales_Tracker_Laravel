<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'date' => ['sometimes', 'date'],
            'clientCode' => ['sometimes', 'string', 'max:40'],
            'clientName' => ['sometimes', 'string', 'max:160'],
            'serviceType' => ['sometimes', 'string', 'in:internet,tv,combo'],
            'requestType' => ['sometimes', 'string', 'in:nuevo_contrato,cambio_plan,recontratacion,retiro,adicion,baja_temporal,otro'],
            'changeReason' => ['nullable', 'string', 'max:120'],
            'planFrom' => ['nullable', 'string', 'max:60'],
            'totalFrom' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
            'plan_id' => ['sometimes', 'exists:plans,id'],
        ];
    }
}
