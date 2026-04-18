<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrolleeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|digits:6|unique:laravel_enrollees,student_id',
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:100',
            'course' => 'required|in:BSIT,BSCS,BSCS-EMC DAT,BSEMC-GD',
            'year' => 'required|integer|between:1,4',
            'block' => 'required|regex:/^[A-Z]{1,5}$/|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.digits' => 'Student ID must be exactly 6 digits.',
            'student_id.unique' => '⚠️ Student already added! This ID is already registered.',
            'name.regex' => 'Name must contain letters only - no numbers.',
            'course.in' => 'Please select a valid course.',
            'year.between' => 'Year level must be between 1 and 4.',
            'block.regex' => 'Block must be capital letters only (max 5 chars).',
        ];
    }
    
    protected function prepareForValidation()
{
    // If dropdown was used, use that value
    if ($this->has('block_select') && !empty($this->block_select)) {
        $this->merge(['block' => $this->block_select]);
    }
}
}