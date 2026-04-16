<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrolleeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:100',
            'course' => 'required|in:BSIT,BSCS,BSCS-EMC DAT,BSEMC-GD',
            'year' => 'required|integer|between:1,4',
            'block' => 'required|regex:/^[A-Z]{1,5}$/|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'Name must contain letters only - no numbers.',
            'course.in' => 'Please select a valid course.',
            'year.between' => 'Year level must be between 1 and 4.',
            'block.regex' => 'Block must be capital letters only (max 5 chars).',
        ];
    }
}