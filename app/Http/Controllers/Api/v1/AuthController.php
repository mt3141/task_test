<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\v1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register (CreateUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        $accessToken = $user->createToken('UserToken')->accessToken;
        return response()->json([
            'user' => new UserResource($user),
            'token' => $accessToken,
            'token_type' => 'Bearer',
            'message' => 'ثبت نام شما با موفقیت انجام شد'
        ]);
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->all();
        if (!auth()->attempt($data)) {
            return response()->json('نام کاربری یا رمز عبور اشتباه است.', 422);
        }
        $user = auth()->user();
        $tokenResult = $user->createToken('userToken');
        $tokenModel = $tokenResult->token;
        if ($request->remember_me) {
            $tokenModel->expires_at = Carbon::now()->addWeeks(1);
        }
        $tokenModel->save();

        return response()->json([
            'user' => new UserResource($user),
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'message' => 'شما با موفقیت وارد شدید'
        ]);
    }

    public function logout(Request $request)
    {
        /** @var User $user
         */
        $request->user()->token()->revoke();
        return response()->json('شما با موفقیت خارج شدید');
    }
}

