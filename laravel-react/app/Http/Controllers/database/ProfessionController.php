<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    public function index()
    {
        return Profession::all(); // Return all professions
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Profession_Name' => 'required|string|max:255',
        ]);

        return Profession::create($validated);
    }

    public function show($id)
    {
        return Profession::findOrFail($id); // Return a single profession by ID
    }

    public function update(Request $request, $id)
    {
        $profession = Profession::findOrFail($id);

        $validated = $request->validate([
            'Profession_Name' => 'required|string|max:255',
        ]);

        $profession->update($validated);

        return $profession;
    }

    public function destroy($id)
    {
        Profession::destroy($id);
        return response()->json(['message' => 'Profession deleted']);
    }
}