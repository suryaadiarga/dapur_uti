<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealScheduleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'schedule_date'  => 'required|date',
            'shift'          => 'required|integer|in:1,2,3',
            'menus'          => 'required|array|min:1', // Validasi array
            'menus.*'        => 'required|string|max:255', // Validasi isi array
            'portion_count'  => 'required|integer|min:1',
            'estimated_cost' => 'nullable|numeric|min:0',
            'notes'          => 'nullable|string',
        ];
    }
}