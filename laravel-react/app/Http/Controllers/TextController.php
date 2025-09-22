<?php

namespace App\Http\Controllers;

use App\Models\Text;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function index()
    {
        return Text::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Text_Name' => 'required|string|max:255',
            'text'      => 'required|string',
        ]);

        return Text::create($validated);
    }

    public function show($id)
    {
        return Text::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $text = Text::findOrFail($id);
        $text->update($request->all());

        return $text;
    }

    public function destroy($id)
    {
        Text::destroy($id);
        return response()->json(['message' => 'Text deleted']);
    }
}
