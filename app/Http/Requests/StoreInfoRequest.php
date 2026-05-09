<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInfoRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'delivery_name' => 'sometimes|string|max:255',
            'gate_status' => 'required|string|in:opened,closed',
            'package_status' => 'required|string|in:arrived,taken',
            'pin' => 'required|digits:4'
        ];
    }
}
