<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            // 'responsible_name' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:45',
             'city_id' => 'required|exists:cities,id',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
