<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    // Get all photos
    public function index()
    {
        return response()->json(Photo::all());
    }

    // Store new photo(s)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
            'urls' => 'required|array',
            'urls.*' => 'required|string'
        ]);

        $photos = [];
        foreach ($request->urls as $url) {
            $photos[] = Photo::create(['title' => $request->title ?? '', 'url' => $url]);
        }

        return response()->json($photos, 201);
    }

    // Update a photo
    public function update(Request $request, Photo $photo)
    {
        $request->validate([
            'title' => 'nullable|string',
            'url' => 'nullable|string'
        ]);

        $photo->update($request->only('title','url'));
        return response()->json($photo);
    }

    // Delete a photo
    public function destroy(Photo $photo)
    {
        $photo->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
