<?php

namespace App\Http\Controllers\Auth;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employe;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->nip) {
            $data = Employe::with('position')->where('nip', $request->nip)->first();
            return Inertia::render('Auth/Search', ['data' => $data]);
        }
        return Inertia::render('Auth/Search');
    }

    public function search(Request $request)
    {
    }
}
