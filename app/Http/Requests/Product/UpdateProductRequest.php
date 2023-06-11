<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('products', 'name')->ignore($this->product->id)->where('user_id', auth()->id())],
            'price' => ['required', 'numeric', 'regex:/^\d+\.\d{2}$/'],
            'quantity' => 'required|integer',
            'description' => 'sometimes|nullable',
            'id' => Rule::exists('products', 'id')->where('user_id', auth()->id())
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'errors' => $validator->errors()->all(),
                'message' => 'Unprocessable Entity',
            ], 422));
        }
    }

    public function prepareForValidation()
    {
        parent::prepareForValidation();
        return $this->merge(['id' => $this->product->id]);
    }
    public function messages(): array
    {
        return [
            'price.regex' => 'The price must be a valid number with exactly two decimal places.'
        ];
    }
}
