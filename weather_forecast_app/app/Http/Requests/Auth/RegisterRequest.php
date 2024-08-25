<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
            'mail' => [
                'required',
                'max:255',
                'email',
                'unique:users,mail'
            ],

            'user_name' => [
                'required',
                'max:50'
            ],

            'otk' => [
                'required',
                'exists:users,otk'
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
            'otk' => 'ワンタイム認証キー',
            'password' => 'パスワード'
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $limiterFlag = RateLimiter::hit($this->throttleKey());
        
        // if (! Auth::attempt($this->only('password'), $this->boolean('remember'))) {
        //     RateLimiter::hit($this->throttleKey());

        //     throw ValidationException::withMessages([
        //         'password' => trans('auth.password_failed'),
        //     ]);
        // }

        if ($limiterFlag === 2) {
            RateLimiter::clear($this->throttleKey());
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 10)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'password' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        Str::lower($this->input('email')).'|'.$this->ip();
        return Str::transliterate(Str::lower($this->input('mail')).'|'.$this->ip());
    }
}
