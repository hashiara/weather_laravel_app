<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AddDataService;
use App\Http\Requests\Auth\RegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Local;
use App\Models\Train;
use Illuminate\Support\Facades\Redirect;

class LoginedController extends Controller
{
    // データ登録画面遷移
    public function index($title, AddDataService $service)
    {
        $user = Auth::user();
        $jsons = $service->getWeatherJson($title);
        $posts = $service->getTrainStatusJson($title);
        
        $user = $service->getAllUserInfo($user);

        return view('main.index', compact('user', 'title', 'jsons', 'posts'));
    }

    /**
     * Display the login view.
     */
    // public function urlError()
    // {
    //     return view('auth.url-error');
    // }

    /**
     * Display the login view.
     */
    public function create(Request $request, $userId)
    {
        $users = User::all();
        $user = $users->where('user_id', $userId)->first();

        if ($user) {
            session(['user' => $user]);
            return redirect()->route('profile.edit');
        }

        return view('auth.register', compact('userId'));
    }

    // ログアウト
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    // アカウント削除
    public function delete(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            Auth::logout();
            User::find($user->id)->forceDelete();
            Local::where('user_id', $user->user_id)->forceDelete();
            Train::where('user_id', $user->user_id)->forceDelete();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return Redirect::to('/');
        }

        return redirect()->route('login.page');
    }
}
