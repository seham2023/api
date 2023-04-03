<?php

namespace App\Http\Requests;

use App\Rules\ResetCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
    public function rules()
    {
        return [
            'username' => 'required|exists:password_resets,' . $this->username(),
            'reset_code' => ['required', new ResetCodeRule($this->username(),$this->input("username"))],
            'password' => 'required|confirmed|min:6',

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
