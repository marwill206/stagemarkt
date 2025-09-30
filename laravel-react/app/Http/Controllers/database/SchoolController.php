<?php


namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        return School::all(); // Return all schools
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'School_Name' => 'required|string|max:255',
        ]);

        return School::create($validated);
    }

    public function show($id)
    {
        return School::findOrFail($id); // Return a single school by ID
    }

    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $validated = $request->validate([
            'School_Name' => 'required|string|max:255',
        ]);

        $school->update($validated);

        return $school;
    }

    public function destroy($id)
    {
        School::destroy($id);
        return response()->json(['message' => 'School deleted']);
    }
}