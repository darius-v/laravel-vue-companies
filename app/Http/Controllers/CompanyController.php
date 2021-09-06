<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    const COMPANY_VALIDATION_RULES = [
        'name' => 'required|max:256',
        'email' => 'required|max:256|email',
        'phone' => 'required|max:256'
    ];

    public function index(Request $request): array
    {
        $pageParameters = json_decode($request->get('lazyEvent'), true);

        if (isset($pageParameters['page'])) {
            $page = $pageParameters['page'];
        } else {
            $page = 0;
        }

        $paginatedCompanies = DB::table('companies')
            ->orderBy('name', 'asc')
            ->offset($page * $pageParameters['rows'])
            ->limit($pageParameters['rows'])
            ->get();

        return ['companies' => $paginatedCompanies, 'totalRecords' => Company::count()];
    }

    public function store(Request $request): JsonResponse
    {
        $company = new Company();

        validator($request->all(), self::COMPANY_VALIDATION_RULES)->validate();

        $company->name = $request->json()->get('name');
        $company->email = $request->json()->get('email');
        $company->phone = $request->json()->get('phone');

        $possibleDuplicatesExist = $this->doDuplicatesExist($company);

        $company->save();

        $message = 'Company created';
        if ($possibleDuplicatesExist) {
            $message .= ' but there is possible duplicate';
        }

        return response()->json(['message' => $message], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        validator($request->all(), self::COMPANY_VALIDATION_RULES)->validate();

        $company = Company::findOrFail($id);
        $company->update($request->all());

        return response()->json($request->all());
    }

    public function uploadLogo(Request $request, int $companyId): Response
    {
        $request->validate([
            'logo' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

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

    public function addContact(Request $request, int $companyId): JsonResponse
    {
        $company = Company::findOrFail($companyId);

        $contact = Contact::find($request->json()->get('contactId'));

        $company->contacts()->attach($contact);

        return response()->json();
    }
//
//    public function delete(Article $article)
//    {
//        $article->delete();
//
//        return response()->json(null, 204);
//    }
    private function doDuplicatesExist(Company $company): bool
    {
        // todo move to repository
        $companies = DB::table('companies')
            ->where('name', '=', $company->name)
            ->orWhere('email', $company->email)
            ->orWhere('phone', $company->phone)
            ->get();

        return count($companies) > 0;
    }
}
