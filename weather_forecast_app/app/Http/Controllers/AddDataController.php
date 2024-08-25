<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;
use App\Services\AddDataService;

class AddDataController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = session('user');

        if (!$user || is_null($user)) {
            return view('profile.timeout');
        }

        $jsonString = Storage::disk('public')->get('city_in_prefecture.json');
        $jsons = json_decode($jsonString, true);

        return view('profile.edit', compact('user', 'jsons'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateRequest $request, $title, AddDataService $service): RedirectResponse
    {
        // ログインが失効していたらログイン画面に遷移
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login.page');
        }

        // データ登録の結果に応じてメッセージとともに元の画面に遷移
        if ($service->update($request, $title, $user)) {
            return back()
                ->withInput()
                ->with('success', config('const.'.$title) . 'の登録が成功しました。');
        } else {
            return back()
                ->withInput()
                ->withErrors(['message' => config('const.'.$title) . 'の登録が失敗しました。']);
        }
    }
}
