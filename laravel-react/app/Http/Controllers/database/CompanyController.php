<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
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
            'Company_Name' => 'required|string|max:255',
            'Company_Email' => 'required|email|unique:companies,Company_Email',
            'Company_Address' => 'nullable|string',
            'KVK' => 'nullable|string',
            'Profession_ID' => 'nullable|exists:professions,Profession_ID', 
            'field' => 'nullable|string',
            'Website_Link' => 'nullable|url',
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
        
        $validated = $request->validate([
            'Company_Name' => 'required|string|max:255',
            'Company_Email' => 'required|email|unique:companies,Company_Email,' . $id . ',Company_ID',
            'Company_Address' => 'nullable|string',
            'KVK' => 'nullable|string',
            'Profession_ID' => 'nullable|exists:professions,Profession_ID', 
            'field' => 'nullable|string',
            'Website_Link' => 'nullable|url',
        ]);

        $company->update($validated);
        return $company;
    }

    public function destroy($id)
    {
        Company::destroy($id);
        return response()->json(['message' => 'Company deleted']);
    }
}