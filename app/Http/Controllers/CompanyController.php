<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create(['name' => $request->name]);
        
        \App\Models\Invitation::create([
            'email' => $request->admin_email,
            'role' => 'Admin',
            'company_id' => $company->id,
            'token' => \Illuminate\Support\Str::random(32),
        ]);

        return redirect()->route('companies.index')->with('success', 'Company created and admin invited successfully.');
    }

}
