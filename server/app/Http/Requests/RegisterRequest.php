<?php

	namespace App\Http\Requests;

	use Illuminate\Foundation\Http\FormRequest;

	class RegisterRequest extends FormRequest
	{
		/**
		 * Determine if the user is authorized to make this request.
		 */
		public function authorize(): bool
		{
			return false;
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
                'email' => 'sometimes|required|string|email:rfc,dns|unique:users,email,'.$this->id,
				'password' => 'sometimes|required|min:8',
				'confirmPassword' => 'sometimes|required|min:8',
				'device_name' => 'required',
			];
		}
        public function messages(): array
        {
            return [
                'name.required' => 'Field name is required',
                'name.min' => 'Field name must be at least 3 characters',
                'email.required' => 'Field email is required',
                'email.unique' => 'This email already exists',
                'password.required' => 'Field password is required',
            ];
        }
	}
