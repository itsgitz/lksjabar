<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:6',
                'unique:App\Models\User,name'
            ],
            'email' => [
                'required',
                'min:6',
                'email',
                'unique:App\Models\User,email'
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
                'min:6'
            ]
        ];
    }
}
