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

        $company->name = $request->json()->get('name') ;
        $company->email = $request->json()->get('email') ;
        $company->phone = $request->json()->get('phone') ;

        $company->save();

        return response()->json([], 201);
    }

//    public function update(Request $request, Article $article)
//    {
//        $article->update($request->all());
//
//        return response()->json($article, 200);
//    }
//
//    public function delete(Article $article)
//    {
//        $article->delete();
//
//        return response()->json(null, 204);
//    }
}
