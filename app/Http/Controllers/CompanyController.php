<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    const COMPANY_VALIDATION_RULES = [
        'name' => 'required|max:256',
        'email' => 'required|max:256|email',
        'phone' => 'required|max:256'
    ];

    public function index(Request $request): array
    {
        $parameters = json_decode($request->get('lazyEvent'), true);

        if (isset($parameters['page'])) {
            $page = $parameters['page'];
        } else {
            $page = 0;
        }

        $queryBuilder = DB::table('companies')

            ->leftJoin('company_contact', 'company_contact.company_id', '=', 'companies.id')
            ->groupBy('companies.id')
        ;

        if (isset($parameters['filters']['name'])) {
            $queryBuilder
                ->where('name', 'like', '%' . $parameters['filters']['name']['value'] . '%')
            ;
        }

        $total = DB::table('companies')
            ->whereIn('id', $queryBuilder->select('companies.id'))
            ->count()
        ;

        $companies = $queryBuilder
            ->select('companies.id', 'name', 'email', 'phone', 'logo', DB::raw("COUNT('company_contact.id') AS contact_count"))
            ->orderBy('name')
            ->offset($page * $parameters['rows'])
            ->limit($parameters['rows'])
            ->get();

        return ['companies' => $companies, 'totalRecords' => $total];
    }

    /**
     * @throws ValidationException
     */
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

    /**
     * @throws ValidationException
     */
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

        // todo - remove previous file
        $company->logo = '/storage/' . $filePath;
        $responseData = [];
        if (strlen($company->logo) > 256) {
            $responseData = ['error' => 'Filename too long'];
        } else {
            $company->save();
        }

        return response($responseData);
//            ->header('Access-Control-Allow-Origin', '*');
//        return response()->json();
    }

    public function addContact(Request $request, int $companyId): JsonResponse
    {
        $company = Company::findOrFail($companyId);

        $contact = Contact::find($request->json()->get('contactId'));

        $company->contacts()->attach($contact);

        return response()->json();
    }

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
