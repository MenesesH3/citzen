<?php

namespace App\Http\Controllers;

use App\Actions\Company\AllCompanies;
use App\Actions\Company\CreateCompany;
use App\Actions\Company\DeleteCompany;
use App\Actions\Company\GetCompany;
use App\Actions\Company\UpdateCompany;
use App\Http\Requests\Company\FilterCompanyRequest;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;

class CompanyController extends Controller
{
    public function index(FilterCompanyRequest $request, AllCompanies $allCompanies)
    {
        $payload = $request->validated();

        $companyName = $request->input('company_name');

        $companies = $allCompanies->handle(
            attributes: ['id', 'company_name', 'trading_name', 'cnpj', 'company_email', 'person_responsible', 'foundation_date'],
            filters: [
                'company_name' => $companyName
            ],
            orderDirection: 'desc',
            withoutPagination: true
        );

        return $this->sendJsonOK($companies->toArray());
    }

    public function store(StoreCompanyRequest $request, CreateCompany $createCompany)
    {
        $payload = $request->validated();

        $createCompany->handle($payload);

        return $this->sendJsonOK();
    }

    public function update($id, UpdateCompanyRequest $request, GetCompany $getCompany, UpdateCompany $updateCompany)
    {
        $payload = $request->validated();

        $company = $getCompany->handle(
            $id,
            attributes: ['id', 'company_name', 'trading_name', 'cnpj', 'company_email', 'person_responsible', 'foundation_date'],
        );

        $updateCompany->handle($company, $payload);

        return $this->sendJsonOK();
    }

    public function show($id, GetCompany $getCompany)
    {
        $company = $getCompany->handle(
            $id,
            attributes: ['company_name', 'trading_name', 'cnpj', 'company_email', 'person_responsible', 'foundation_date'],
        );

        return $this->sendJsonOK($company->toArray());
    }

    public function delete($id, GetCompany $getCompany, DeleteCompany $deleteCompany)
    {
        $company = $getCompany->handle(
            $id,
            attributes: ['id', 'company_name', 'trading_name', 'cnpj', 'company_email', 'person_responsible', 'foundation_date'],
        );

        $deleteCompany->handle($company);

        return $this->sendJsonOK();
    }
}
