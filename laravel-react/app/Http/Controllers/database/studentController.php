<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class StudentController extends Controller
{
    public function index()
    {
        return Student::all();
    }

    //create

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Student_Name' => 'required|string|max:255',
            'Student_Email' => 'required|email|unique:students,Student_Email',
            'Address' => 'nullable|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:Male,Female,Other',
            'foto' => 'nullable|string',
            'Profession_ID' => 'nullable|exists:professions,Profession_ID',
            'School_ID' => 'nullable|exists:schools,School_ID',
        ]);
        return Student::create($validated);
    }

    //show

    public function show($id)
    {
        return Student::findOrFail(
            $id
        );
    }

    //update

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'Student_Name' => 'required|string|max:255',
            'Student_Email' => 'required|email|unique:students,Student_Email,' . $id . ',Student_ID',
            'Address' => 'nullable|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:Male,Female,Other',
            'foto' => 'nullable|string',
            'Profession_ID' => 'nullable|exists:professions,Profession_ID',
            'School_ID' => 'nullable|exists:schools,School_ID',
        ]);

        $student->update($validated);

        return $student;
    }

    //delete

    public function destroy($id)
    {
        Student::destroy($id);
        return response()->json(['message' => 'student deleted']);
    }
}
