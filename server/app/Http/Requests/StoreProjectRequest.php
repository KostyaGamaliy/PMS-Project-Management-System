<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100',
            'descriptions' => 'string|min:5|max:1000',
            'preview_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required|integer|exists:users,id'
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
            'preview_image.required' => 'This field must be filled in',
            'preview_image.image' => 'this field should be a picture',
            'preview_image.mimes' => 'this field must be named with the extension: jpeg,png,jpg,gif,svg',
            'preview_image.max' => 'The size of the picture must be less than 2048',
        ];
    }
}
