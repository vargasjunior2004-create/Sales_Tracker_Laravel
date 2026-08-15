<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashCountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'coin_050' => ['sometimes', 'integer', 'min:0'],
            'coin_1' => ['sometimes', 'integer', 'min:0'],
            'coin_2' => ['sometimes', 'integer', 'min:0'],
            'coin_5' => ['sometimes', 'integer', 'min:0'],
            'bill_10' => ['sometimes', 'integer', 'min:0'],
            'bill_20' => ['sometimes', 'integer', 'min:0'],
            'bill_50' => ['sometimes', 'integer', 'min:0'],
            'bill_100' => ['sometimes', 'integer', 'min:0'],
            'bill_200' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
