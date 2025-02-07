<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:13|regex:/^[0-9]+$/',
            'ymd' => 'required|date',
            'user_id' => 'required|integer|exists:users,id|unique:students,user_id',
        ];
    }
}
