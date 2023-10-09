<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class GetUser
{
    public function handle(int $id, array $attributes = [], array $relations = [], array $filters = [], array $hidden = [], array $appends = []): Model
    {
        $data = User::query()
            ->when($attributes ?? null, function ($query) use ($attributes) {
                $query->select($attributes);
            })
            ->with($relations)
            ->where('id', $id)
            ->first();

        if (!$data) {
            abort(Response::HTTP_NOT_FOUND, 'Usuário não encontrado. Por favor, tente novamente!');
        }

        return $data->makeHidden($hidden)->append($appends);
    }
}
