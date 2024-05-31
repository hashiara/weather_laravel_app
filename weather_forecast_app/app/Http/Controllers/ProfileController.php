<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = session('user');
        $userModel = User::find($user->id);

        if ($userModel && $request) {
            // ユーザー情報の更新
            $userModel->fill($request->validated());
            $userModel->save();
    
            // 必要に応じてセッション情報を更新
            session(['user' => $userModel]);
    
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } else {
            return back()
                ->withInput()
                ->withErrors(['message' => 'セッションがタイムアウトしました。もう一度LineメッセージのURLからアクセスし直してください。']);
        }


        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        // return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'user_id' => ['required'],
        ]);

        // $user = $request->user();
        $users = User::all();
        $user = $users->where('user_id', $request->user_id)->first();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/' . $request->user_id);
    }
}
