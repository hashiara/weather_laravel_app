<?php

declare(strict_types=1);

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Models\User;
use App\Models\Local;
use App\Models\Train;

class AddDataService
{
    // 天気予報データ取得
    public function getWeatherJson($title)
    {
        if ($title === "weather") {
            $jsonString = Storage::disk('public')->get('city_in_prefecture.json');
            $jsons = json_decode($jsonString, true);
        } else {
            $jsons = null;
        }

        return $jsons;
    }

    // 路線情報取得
    public function getTrainStatusJson($title)
    {
        if ($title === "trainStatus") {
            $url = "https://ntool.online/data/train_all.json";
            $method = "GET";

            $client = new Client();

            $response = $client->request($method, $url);

            $posts = $response->getBody()->getContents();
            $posts = json_decode($posts, true);
        } else {
            $posts = null;
        }

        return $posts;
    }

    // ユーザーの全データ取得
    public function getAllUserInfo($user)
    {
        $local = Local::getLocalInfo($user->user_id);
        $user->prefecture = $local ? $local->prefecture : null;
        $user->city = $local ? $local->city : null;

        $train = Train::getTrainInfo($user->user_id);
        $user->area_code = $train ? $train->area_code : null;
        $user->rail_order = $train ? $train->rail_order : null;

        return $user;
    }

    // データ登録・更新
    public function update($request, $title, $user)
    {
        // $titleに応じてデータ登録するModelを分ける
        if ($title === "weather") {
            return Local::store($request, $user);
        } elseif ($title === "horoscope") {
            return User::store($request, $user);
        } elseif ($title === "trainStatus") {
            return Train::store($request, $user);
        } else {
            return false;
        }
    }
}
