<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Attendance;

class AttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attendance_date' => ['required', 'date'],
            'people_id' => ['required', 'exists:people,id'],
            'status' => ['required', Rule::in(array_keys(Attendance::STATUSES))],
            'notes' => ['nullable', 'string'],
        ];
    }
}