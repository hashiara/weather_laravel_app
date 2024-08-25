<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;

// class RegisterdUserService extends BaseService
class RegisterdUserService
{
    public function registerUser(RegisterRequest $request)
    {
        return User::registerUser($request['otk'], $request);
    }

    public function loginCheck($request)
    {
        return User::loginCheck($request);
    }
}
