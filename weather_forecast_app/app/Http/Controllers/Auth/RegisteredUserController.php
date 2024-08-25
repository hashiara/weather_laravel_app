<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\LoggingRequest;
use App\Services\RegisterdUserService;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // ユーザー登録
    public function store(RegisterRequest $request, RegisterdUserService $service)
    {
        $result = $service->registerUser($request);

        // 認証成功
        if (isset($result['success'])) {
            User::deleteOtk($result['user']);
            Auth::login($result['user']);
            return redirect()->route('main.index', ['title' => 'weather']);
        }

        // 認証失敗
        return back()
            ->withInput($request->except('otk'))
            ->with('error', $result['error']);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // ログイン
    public function login(LoggingRequest $request, RegisterdUserService $service)
    {
        $credentials = $request->only('mail', 'user_name', 'password');
        $result = $service->loginCheck($credentials);
        // dd($credentials);

        // 認証成功
        if ($result && Auth::attempt(['mail' => $result->mail, 'user_name' => $result->user_name, 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            // return redirect()->intended('addData');
            return redirect()->route('main.index', ['title' => 'weather']);
        }

        // 認証失敗
        return back()->withErrors([
            'failed' => 'メールアドレス、ユーザー名またはパスワードが違います',
        ])->onlyInput('mail', 'user_name');
    }
}
