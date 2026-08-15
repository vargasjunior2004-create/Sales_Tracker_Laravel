<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OutflowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'personName' => ['required', 'string', 'max:160'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'concept' => ['nullable', 'string', 'max:255'],
        ];
    }
}
