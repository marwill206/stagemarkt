<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;

use App\Models\StudentSkill;
use Illuminate\Http\Request;

class StudentSkillController extends Controller
{
    public function index()
    {
        return StudentSkill::with(['student', 'skill'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'skill_id' => 'required|exists:skill,skill_id',
            'skill_level' => 'required|string|max:255',
        ]);

        return StudentSkill::create($validated);
    }

    public function show($id)
    {
        return StudentSkill::with(['student', 'skill'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $studentskill = StudentSkill::findOrFail($id);
        $studentskill->update($request->all());

        return $studentskill;
    }

    public function destroy($id)
    {
        StudentSkill::destroy($id);
        return response()->json(['message' => 'StudentSkill deleted']);
    }
}
