<?php

namespace App\Http\Requests;

use App\Models\ExpenseTransaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpenseTransactionRequest extends FormRequest
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
            'category' => ['required', Rule::in(array_keys(ExpenseTransaction::CATEGORIES))],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', Rule::in(array_keys(ExpenseTransaction::PAYMENT_METHODS))],
            'store_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'receipt' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
