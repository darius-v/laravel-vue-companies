<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
//    public function index()
//    {
//        return Article::all();
//    }
//
//    public function show(Article $article)
//    {
//        return $article;
//    }

    public function store(Request $request)
    {
//        $article = Company::create($request->all());

//        return response()->json($article, 201);
        return response()->json(['test'], 201);
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
