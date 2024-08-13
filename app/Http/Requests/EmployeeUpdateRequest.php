<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'name' => 'nullable|string',
            'phone' => 'nullable|string',
            'division_id' => 'nullable|exists:divisions,id',
            'position' => 'nullable|string',
        ];
    }
}
