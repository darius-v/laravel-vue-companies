<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function search(string $query): JsonResponse
    {
        $likeCondition = '%' . $query . '%';

        // todo move to repository
        $contacts = DB::table('contacts')
            ->orWhere('name', 'like', $likeCondition)
            ->orWhere('email', 'like', $likeCondition)
            ->orWhere('phone', 'like', $likeCondition)
            ->get()
        ;

        return response()->json($contacts);
    }
}
