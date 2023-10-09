<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class CheckCnaeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::get('https://brasilapi.com.br/api/cnpj/v1/' . $value);

        if ($response->successful()) {
            $company = $response->json();
            $secondaryCanes = collect($company['cnaes_secundarios'])->contains('codigo', '6202300');

            if (!($company['cnae_fiscal'] == '6202300' || $secondaryCanes)) {
                $fail('O ' . $attribute . ' deve possuir Atividade econômica principal ou secundária com código igual a: 62.02-3-00 - Desenvolvimento e licenciamento de programas de computador customizáveis.');
            }
        } else {
            $fail('CNPJ inválido. Entre em contato com a equipe de suporte!');
        }
    }
}
