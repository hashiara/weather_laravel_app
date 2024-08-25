<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'users';

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    protected $fillable = [
        'mail',
        'user_name',
        'otk',
        'password',
        'birth'
    ];

    public static function registerUser($otk, $request)
    {
        // ワンタイム認証キーの一致かつ有効期限切れでないユーザーの検索
        $tenMinutesAgo = Carbon::now()->subMinutes(10);
        $user = self::where('otk', $otk)
            ->where('created_at', '>=', $tenMinutesAgo)
            ->first();
        
        // ユーザー不一致
        if (!$user) {
            $otkMismatch = self::where('otk', $otk)->doesntExist();
            if ($otkMismatch) {
                return ['error' => 'ワンタイム認証キーが違います'];
            }

            $timeExpired = self::where('otk', $otk)
                ->where('created_at', '<', $tenMinutesAgo)
                ->exists();
            if ($timeExpired) {
                // self::where('otk', $otk)->delete(); ソフトデリート
                self::where('otk', $otk)->forceDelete();
                return ['error' => 'ワンタイム認証キーの有効期限が切れています。<br>「地域を登録/更新」を押して再発行してください'];
            }

            return ['error' => 'ユーザー登録に失敗しました'];
        }

        // ユーザー一致
        $updateUser = $user->update([
            'mail' => $request['mail'],
            'user_name' => $request['user_name'],
            'password' => Hash::make($request['password']),
        ]);

        if ($updateUser) {
            return [
                'success' => 'ユーザー登録に成功しました',
                'user' => $user
            ];
        }
    }

    public static function deleteOtk($user)
    {
        $user->update(['otk' => null]);
    }

    public static function loginCheck($credentials)
    {
        // mail または user_name のどちらかを使用してユーザーを検索
        return User::where('mail', $credentials['mail'])
                    ->orWhere('user_name', $credentials['user_name'])
                    ->first() ?: false;
    }

    // 星占いデータ登録
    public static function store($request, $user)
    {
        $userId = $user->user_id;
        $data = $request->only(['birth']);

        // テーブルに同じユーザーIDのレコードがあれば$requestのみ更新し、なければ$requestと$userIdを新規登録する
        return self::upsert(
            [array_merge($data, ['user_id' => $userId])],
            ['user_id']
        );
    }
    

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var array<string, string>
    //  */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];
}
