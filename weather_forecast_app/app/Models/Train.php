<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $table = 'train';

    protected $fillable = [
        'area_code',
        'rail_order'
    ];

    // 取得
    public static function getTrainInfo($user_id)
    {
        return self::where('user_id', $user_id)
                    ->select([
                        'area_code', 
                        'rail_order'
                    ])->first();
    }

    // 路線情報データ登録
    public static function store($request, $user)
    {
        $userId = $user->user_id;
        $data = $request->only(['area_code', 'rail_order']);

        // テーブルに同じユーザーIDのレコードがあれば$requestのみ更新し、なければ$requestと$userIdを新規登録する
        return self::upsert(
            [array_merge($data, ['user_id' => $userId])],
            ['user_id']
        );
    }
}
