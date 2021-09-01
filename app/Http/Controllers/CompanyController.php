<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return Company::all();
    }
//
//    public function show(Article $article)
//    {
//        return $article;
//    }

    public function store(Request $request): JsonResponse
    {
        $company = new Company();

        $this->saveCompanyFromRequest($company, $request);

        $company->save();

        return response()->json([], 201);
    }

    public function update(Request $request, int $id)
    {
//        $this->saveCompanyFromRequest($company, $request);
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json($request->all(), 200);
    }

    private function saveCompanyFromRequest(Company $company, Request $request)
    {
        $company->name = $request->json()->get('name');
        $company->email = $request->json()->get('email');
        $company->phone = $request->json()->get('phone');

    }
//
//    public function delete(Article $article)
//    {
//        $article->delete();
//
//        return response()->json(null, 204);
//    }
}
