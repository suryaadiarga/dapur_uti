<?php

namespace App\Http\Requests;

use App\Models\IncomeTransaction;
use Illuminate\Database\Query\Builder;
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
            'people_id' => [
                'required',
                Rule::exists('people', 'id')->where(function (Builder $query): void {
                    if (! $this->user()->isAdmin()) {
                        $query->where('user_id', $this->user()->id);
                    }
                    $query->whereNull('deleted_at');
                }),
            ],
            'category' => ['required', Rule::in(array_keys(IncomeTransaction::CATEGORIES))],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', Rule::in(array_keys(IncomeTransaction::PAYMENT_METHODS))],
            'description' => ['nullable', 'string', 'max:3000'],
            'proof' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}
