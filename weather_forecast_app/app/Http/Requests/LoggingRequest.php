<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoggingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mail' => [
                'nullable',
                'required_without:user_name',
                'max:255',
                'email'
            ],

            'user_name' => [
                'nullable',
                'required_without:mail',
                'max:50'
            ],

            'password' => [
                'required', 
                'min:8',
                'max:12',
                'regex:/^[a-zA-Z0-9!\-\/\:\-\@\¥\[\-\`\{\-\~ａ-ｚＡ-Ｚ０-９！-／：-＠［-｀｛-～]+$/u'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'mail' => 'メールアドレス',
            'user_name' => 'ユーザー名',
            'password' => 'パスワード'
        ];
    }
}
