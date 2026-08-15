<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['sometimes', 'string', 'in:admin,ventas'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
