<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class WebhookRequest extends FormRequest
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
            "debtId" => "required",
            "paidAt" => "required",
            "paidAmount" => "required",
            "paidBy" => "required|max:255"
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
            'required' => 'The :attribute field is required.'
        ];
    }
}
