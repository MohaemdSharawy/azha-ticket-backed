<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            'phone' => 'required',
            'email'  => "required|email",
            'password' => 'required',
            'birth_day' => 'required',
            'gender' => 'required',
            'unit' => 'required',
            'role' => 'required',
            'property' => 'required|array'
        ];
    }
}
