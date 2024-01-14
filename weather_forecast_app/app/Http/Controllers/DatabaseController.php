<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB; 
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DatabaseController extends Controller
{
    public function getIndex(Request $request)
    {
        $data = DB::select('select * from users');
        return view('database', ['message' => 'weather_info_db','data' => $data]);
    }
}
