<?php

namespace App\Http\Requests;

use App\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in(array_keys(Person::ROLES))],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];

        if ($this->user()->isAdmin()) {
            $rules['user_id'] = ['nullable', 'integer', Rule::exists('users', 'id')];
        }

        return $rules;
    }
}
