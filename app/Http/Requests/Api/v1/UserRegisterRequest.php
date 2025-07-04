<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }

    public function getUserName(): string
    {
        return $this->get('name');
    }

    public function getUserEmail(): string
    {
        return $this->get('email');
    }

    public function getUserPassword(): string
    {
        return $this->get('password');
    }
}
