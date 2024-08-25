<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $table = 'local';

    protected $fillable = [
        'prefecture',
        'city',
    ];

    // 取得
    public static function getLocalInfo($user_id)
    {
        return self::where('user_id', $user_id)
                    ->select([
                        'prefecture', 
                        'city'
                    ])->first();
    }

    // 天気予報データ登録
    public static function store($request, $user)
    {
        $userId = $user->user_id;
        $data = $request->only(['prefecture', 'city']);

        // テーブルに同じユーザーIDのレコードがあれば$requestのみ更新し、なければ$requestと$userIdを新規登録する
        return self::upsert(
            [array_merge($data, ['user_id' => $userId])],
            ['user_id']
        );
    }
}
