<?php

namespace App\Actions\User;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class CreateLoginAccessToken
{
    public function handle(Authenticatable|Model $model, string $key = 'api'): string
    {
        return $model->createToken($key)->plainTextToken;
    }
}
