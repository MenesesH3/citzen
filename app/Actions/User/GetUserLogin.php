<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class GetUserLogin
{
    public function handle(string $email, string $password): Model
    {
        $data = User::query()
            ->select('id', 'name', 'email', 'password')
            ->where('email', $email)
            ->first();

        if (!$data || !Hash::check($password, $data->password)) {
            abort(Response::HTTP_FORBIDDEN, 'E-mail ou senha incorretos.');
        }

        return $data;
    }
}
