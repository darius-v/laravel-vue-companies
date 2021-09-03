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


//        $request->validate([ // todo this create cors error
//            'file' => 'required|mimes:jpg,jpeg,png|max:2048'
//        ]);



        $company = Company::findOrFail($companyId);


        if($request->file()) {

            // ten logo[] siuncia bet jei parasayu cia logo[] tai irgi klaida. Neikertu.
//            $path = $request->file('logo')[]->store('avatars');

            $files = $request->file('logo');


//            print_r($file);

            $name = time().'_'.$files[0]->getClientOriginalName();
//            $filePath = $request->file('file')->storeAs('uploads', $name, 'public');
//
//            $company->logo = '/storage/' . $filePath . '/' . time().'_'.$request->file->getClientOriginalName();;
//            if (strlen($company->logo) > 256) {
//                return response(['error' => 'Filename too long ']);
//            } else {
//                $company->save();
//
//                return response([]);
//            }
        }
        return response([]);
    }
//
//    public function delete(Article $article)
//    {
//        $article->delete();
//
//        return response()->json(null, 204);
//    }
}
