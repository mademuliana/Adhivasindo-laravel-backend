<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'role' => 'required|in:student,admin',
            'email' => 'required|email|unique:users,email,' . $this->user?->id,
            'password' => 'nullable|string|min:6',
        ];
    }
}
