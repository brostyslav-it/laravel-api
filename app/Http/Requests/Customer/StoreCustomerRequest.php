<?php

namespace App\Http\Requests\Customer;

use App\Models\Customer\Enums\CustomerType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tokenCan('create');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:1', Rule::in(CustomerType::toArray())],
            'email' => ['required', 'email', 'max:255', 'unique:customers'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:20'],
            'postalCode' => ['required', 'string', 'max:10'],
        ];
    }

    protected function prepareForValidation(): Request
    {
        return $this->merge([
            'postal_code' => $this->postalCode,
        ]);
    }
}
