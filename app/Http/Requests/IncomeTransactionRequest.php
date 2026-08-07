<?php

namespace App\Http\Requests;

use App\Models\IncomeTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IncomeTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_date' => ['required', 'date'],
            'people_id' => ['required', 'exists:people,id'],
            'category' => ['required', Rule::in(array_keys(IncomeTransaction::CATEGORIES))],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', Rule::in(array_keys(IncomeTransaction::PAYMENT_METHODS))],
            'description' => ['nullable', 'string', 'max:3000'],
            'proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
