<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:13|regex:/^[0-9]+$/',
            'ymd' => 'required|date',
        ];
    }
}
