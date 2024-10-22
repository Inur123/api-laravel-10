<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PodcastController extends Controller
{
    public function index()
    {
        // Ambil semua item podcast untuk pengguna yang terautentikasi
        $podcasts = Podcast::all();

        return response()->json(['message' => 'Data retrieved successfully', 'data' => $podcasts], 200);
    }

    public function store(Request $request)
    {
        // Hanya admin yang dapat menambah data
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validasi data yang diterima
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
        ]);

        // Simpan data podcast dengan ID pengguna yang terautentikasi
        $podcast = Podcast::create([
            'user_id' => Auth::id(), // Simpan ID pengguna
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return response()->json(['message' => 'Podcast created successfully!', 'data' => $podcast], 201);
    }

    public function show($id)
    {
        // Ambil item podcast berdasarkan ID
        $podcast = Podcast::find($id);

        if (!$podcast) {
            return response()->json(['message' => 'Podcast not found.'], 404);
        }

        return response()->json(['message' => 'Data retrieved successfully', 'data' => $podcast], 200);
    }

    public function update(Request $request, $id)
    {
        // Hanya admin yang dapat mengupdate data
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validasi data yang diterima
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
        ]);

        // Cari item podcast berdasarkan ID
        $podcast = Podcast::find($id);

        if (!$podcast) {
            return response()->json(['message' => 'Podcast not found.'], 404);
        }

        // Update data
        $podcast->update($request->all());

        return response()->json(['message' => 'Podcast updated successfully!', 'data' => $podcast], 200);
    }

    public function destroy($id)
    {
        // Hanya admin yang dapat menghapus data
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Cari item podcast berdasarkan ID
        $podcast = Podcast::find($id);

        if (!$podcast) {
            return response()->json(['message' => 'Podcast not found.'], 404);
        }

        $podcast->delete();

        return response()->json(['message' => 'Podcast deleted successfully!'], 200);
    }
}
