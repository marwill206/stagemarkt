<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        return Skill::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill_name' => 'required|string|max:255|unique:skill,skill_name',
        ]);

        return Skill::create($validated);
    }

    public function show($id)
    {
        return Skill::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);
        $skill->update($request->all());

        return $skill;
    }

    public function destroy($id)
    {
        Skill::destroy($id);
        return response()->json(['message' => 'Skill deleted']);
    }
}
