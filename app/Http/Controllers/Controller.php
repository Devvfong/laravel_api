<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    // GET /api/photos
    public function index()
    {
        return Photo::all();
    }

    // GET /api/photos/{id}
    public function show($id)
    {
        $photo = Photo::find($id);
        if (!$photo) return response()->json(['error' => 'Not found'], 404);
        return $photo;
    }

    // POST /api/photos
    public function store(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'url' => 'required|string'
        ]);

        $photo = Photo::create($data);

        return response()->json($photo, 201);
    }

    // PUT /api/photos/{id}
    public function update(Request $request, $id)
    {
        $photo = Photo::find($id);
        if (!$photo) return response()->json(['error' => 'Not found'], 404);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'url' => 'sometimes|string'
        ]);

        $photo->update($data);

        return response()->json($photo);
    }

    // DELETE /api/photos/{id}
    public function destroy($id)
    {
        $photo = Photo::find($id);
        if (!$photo) return response()->json(['error' => 'Not found'], 404);

        $photo->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
