<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:45',
            'address' => 'nullable|string|max:255',
        ];
    }
}
