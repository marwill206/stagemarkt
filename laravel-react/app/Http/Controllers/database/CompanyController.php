<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return Company::with('profession')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|unique:company,company_email',
            'company_address' => 'nullable|string',
            'kvk' => 'nullable|string',
            'profession_id' => 'required|exists:profession,id',
            'field' => 'nullable|string',
        ]);

        return Company::create($validated);
    }

    public function show($id)
    {
        return Company::with('profession')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());

        return $company;
    }

    public function destroy($id)
    {
        Company::destroy($id);
        return response()->json(['message' => 'Company deleted']);
    }
}
