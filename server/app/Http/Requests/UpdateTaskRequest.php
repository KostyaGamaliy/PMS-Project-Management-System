<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|min:3|max:100',
            'description' => 'string|min:5|max:1000',
            'status' => 'string|min:3|max:50',
            'user_id' => 'integer|exists:users,id',
            'assigner_id' => 'sometimes|required|integer|exists:users,id',
            'dashboard_id' => 'sometimes|required|integer|exists:dashboards,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'This field must be filled in',
            'name.string' => 'This field should be a string',
            'name.min' => 'This field must be longer than 3 characters',
            'name.max' => 'This field must be less than 100 characters long',
            'description.string' => 'This field should be a string',
            'description.min' => 'This field must be longer than 5 characters',
            'description.max' => 'This field must be less than 1000 characters long',
            'status.string' => 'This field should be a string',
            'status.min' => 'This field must be longer than 3 characters',
            'status.max' => 'This field must be less than 50 characters long',
            'assigner_id' => 'This 1 field must be filled in',
            'dashboard_id' => 'This 2 field must be filled in',
        ];
    }
}
