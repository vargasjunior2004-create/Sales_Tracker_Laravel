<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:30', 'unique:plans,code,' . $this->route('plan')?->id],
            'label' => ['required', 'string', 'max:120'],
            'type' => ['required', 'string', 'in:internet,tv,combo'],
            'speed' => ['nullable', 'integer', 'min:0'],
            'monthly' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'installation' => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'active' => ['sometimes', 'boolean'],
            'legacy' => ['sometimes', 'boolean'],
        ];
    }
}
