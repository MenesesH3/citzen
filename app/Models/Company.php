<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'trading_name',
        'cnpj',
        'company_email',
        'person_responsible',
        'foundation_date',
    ];

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['company_name'] ?? null, function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('company_name', 'like', '%' . $value . '%');
            });
        });
    }
}
