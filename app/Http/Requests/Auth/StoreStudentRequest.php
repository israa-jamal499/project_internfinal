<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'university_number' => 'required|string|max:45|unique:students,university_number',
            'college_id' => 'required|exists:colleges,id',
            'specialization_id' => 'required|exists:specializations,id',
            'city_id' => 'required|exists:cities,id',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
