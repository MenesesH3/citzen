<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateLoginAccessToken;
use App\Actions\User\GetUser;
use App\Actions\User\GetUserLogin;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    public function store(LoginRequest $request, GetUserLogin $getUserToLogin, CreateLoginAccessToken $createNewAccessToken, GetUser $getUser)
    {
        try {
            $payload = $request->validated();

            $authenticatedUser = $getUserToLogin->handle($payload['email'], $payload['password']);
            $token = $createNewAccessToken->handle($authenticatedUser);
            $user = $getUser->handle(
                $authenticatedUser->id,
                attributes: ['id', 'name', 'email', 'email_verified_at'],
            );

            return $this->sendJsonOK(['user' => $user, 'token' => $token]);
        } catch (Exception $error) {
            return $this->sendJsonError($error);
        }
    }
}
