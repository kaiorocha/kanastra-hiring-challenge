<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class DebitStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'debitsFile' => 'required|mimes:csv,txt'
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     * @throws ApiException
     */
    public function failedValidation(Validator $validator)
    {
        throw new ApiException($validator->errors()->first());
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute field must be a csv or txt file.'
        ];
    }
}
