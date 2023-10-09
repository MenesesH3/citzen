<?php

namespace App\Actions\Company;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class GetCompany
{
    public function handle($id, array $attributes = [], array $relations = [], array $hidden = [], array $appends = []): Model
    {
        $data = Company::query()
            ->when($attributes ?? null, function ($query) use ($attributes) {
                $query->select($attributes);
            })
            ->with($relations)
            ->where('id', $id)
            ->first();

        if (!$data) {
            abort(Response::HTTP_NOT_FOUND, 'Empresa não encontrada');
        }

        return $data->makeHidden($hidden)->append($appends);
    }
}
