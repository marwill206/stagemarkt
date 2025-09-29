<?php
namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        return Image::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'img_name' => 'required|string|max:255',
            'img_url'  => 'required|string|max:255', // File path or URL
        ]);

        return Image::create($validated);
    }

    public function show($id)
    {
        return Image::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        $image->update($request->all());

        return $image;
    }

    public function destroy($id)
    {
        Image::destroy($id);
        return response()->json(['message' => 'Image deleted']);
    }
}
