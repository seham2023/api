<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendResetCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
         return [
            'username' => 'required|exists:users,' . $this->username(),
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return string
     */
    public function username(): string
    {
        return (filter_var(request()['username'], FILTER_VALIDATE_EMAIL)) ? 'email' : 'mobile';
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'type' => $this->username(),
        ]);
    }
}
