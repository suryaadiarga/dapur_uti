<?php

namespace App\Http\Requests;

use App\Models\Inventory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(array_keys(Inventory::CATEGORIES))],
            'purchase_date' => ['required', 'date'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
            'condition' => ['required', Rule::in(array_keys(Inventory::CONDITIONS))],
            'location' => ['nullable', 'string', 'max:255'],
            'people_id' => [
                'required',
                Rule::exists('people', 'id')->where(function (Builder $query): void {
                    if (! $this->user()->isAdmin()) {
                        $query->where('user_id', $this->user()->id);
                    }
                    $query->whereNull('deleted_at');
                }),
            ],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'description' => ['nullable', 'string', 'max:3000'],
        ];
    }
}
