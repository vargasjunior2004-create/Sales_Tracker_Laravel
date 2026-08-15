<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'clientCode' => ['required', 'string', 'max:40'],
            'clientName' => ['required', 'string', 'max:160'],
            'serviceType' => ['required', 'string', 'in:internet,tv,combo'],
            'requestType' => ['sometimes', 'string', 'in:nuevo_contrato,cambio_plan,recontratacion,retiro,adicion,baja_temporal,otro'],
            'changeReason' => ['nullable', 'string', 'max:120'],
            'planFrom' => ['nullable', 'string', 'max:60'],
            'totalFrom' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:255'],
            'planId' => ['required', 'exists:plans,id'],
            'plan_id' => ['sometimes', 'required', 'exists:plans,id'],
        ];
    }
}
