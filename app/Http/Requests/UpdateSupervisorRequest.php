<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupervisorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:45',
            'city_id' => 'nullable|exists:cities,id',
            'college_id' => 'nullable|exists:colleges,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];
    }
}
