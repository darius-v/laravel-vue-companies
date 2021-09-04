<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

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
        try {
            $request->validate([
                'logo' => 'required|mimes:jpg,jpeg,png|max:2048'
            ]);
        } catch (Throwable $e) {
            return response(['error' => $e->getMessage()]);
        }

        $company = Company::findOrFail($companyId);

        $file = $request->file('logo');

        $name = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $name, 'public');

        $company->logo = '/storage/' . $filePath;
        if (strlen($company->logo) > 256) {
            return response(['error' => 'Filename too long']);
        } else {
            $company->save();

            return response([]);
        }
    }
//
//    public function delete(Article $article)
//    {
//        $article->delete();
//
//        return response()->json(null, 204);
//    }
}
