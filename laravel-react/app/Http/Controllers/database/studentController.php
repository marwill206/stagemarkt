<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Student_Name' => 'required|string|max:255',
            'Student_Email' => 'required|email|unique:students,Student_Email',
            'Portfolio_Link' => 'nullable|url',
            'About_Text' => 'nullable|string',
            'Address' => 'nullable|string',
            'Age' => 'nullable|integer|min:16|max:100',
            'Gender' => 'nullable|in:Male,Female,Other',
            'Foto' => 'nullable|string',
            'Profession_ID' => 'nullable|exists:professions,Profession_ID',
            'School_ID' => 'nullable|exists:schools,School_ID',
        ]);
        
        return Student::create($validated);
    }

    public function show($id)
    {
        return Student::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'Student_Name' => 'required|string|max:255',
            'Student_Email' => 'required|email|unique:students,Student_Email,' . $id . ',Student_ID',
            'Portfolio_Link' => 'nullable|url',
            'About_Text' => 'nullable|string',
            'Address' => 'nullable|string',
            'Age' => 'nullable|integer|min:16|max:100',
            'Gender' => 'nullable|in:Male,Female,Other',
            'Foto' => 'nullable|string',
            'Profession_ID' => 'nullable|exists:professions,Profession_ID',
            'School_ID' => 'nullable|exists:schools,School_ID',
        ]);

        $student->update($validated);
        return $student;
    }

    public function destroy($id)
    {
        Student::destroy($id);
        return response()->json(['message' => 'Student deleted']);
    }
}

