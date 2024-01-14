<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    public function store(Request $request)
    {
        // バリデーションルールを定義
        $rules = [
            'user_id' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255', 'unique:users'],
        ];

        // カスタムエラーメッセージを定義
        $messages = [
            'user_id.unique' => 'このアカウントは既に存在しています。',
            'name.unique' => 'この名前は既に使われています。',
        ];

        // バリデーションを実行
        $request->validate($rules, $messages);

        $newUser = new User();

        $createUser = $newUser->create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            // 'password' => Hash::make($request->password),
        ]);

        $user = $createUser->where('id', $createUser->id)->first();
        
        if ($user) {
            session(['user' => $user]);
            return redirect()->route('profile.edit');
        } else {
            return back()
                ->withInput()
                ->withErrors(['message' => '正常に登録できませんでした。']);
        }
    }
}
