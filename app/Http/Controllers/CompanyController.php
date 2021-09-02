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

        $company->name = $request->json()->get('name');
        $company->email = $request->json()->get('email');
        $company->phone = $request->json()->get('phone');

        $company->save();

        return response()->json([], 201);
    }

    public function update(Request $request, int $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json($request->all(), 200);
    }

    public function uploadLogo(Request $request, int $companyId)
    {


        return response('test');



        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

        $company = Company::findOrFail($companyId);

        if($request->file()) {
            $file_name = time().'_'.$request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');

//            $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
//            $fileUpload->path = '/storage/' . $file_path;
//            $fileUpload->save();

            return response()->json($file_path);
        }

        return 'test';
    }
//
//    public function delete(Article $article)
//    {
//        $article->delete();
//
//        return response()->json(null, 204);
//    }
}
