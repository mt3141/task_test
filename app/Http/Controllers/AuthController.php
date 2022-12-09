<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends Controller
{

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = JWTAuth::attempt($request->validated());
            if (!$token) {
                return response()->json(
                    [
                        'type' => 'error',
                        'data' => 'username or password is wrong'
                    ]
                );
            }

            return response()->json(
                [
                    'token' => $token,
                    'data' => new UserResource($request->user())
                ]
            );
        } catch (JWTException $e) {

            return response()->json(
                [
                    'type' => 'error',
                    'data' => $e
                ]
            );
        }
    }
}
