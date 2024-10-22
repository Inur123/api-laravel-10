<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GirlyPedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GirlyPediaController extends Controller
{
    public function index()
    {
        // Ambil semua item GirlyPedia untuk pengguna yang terautentikasi
        $girlyPediaItems = GirlyPedia::where('user_id', Auth::id())->get();

        return response()->json(['message' => 'Data retrieved successfully', 'data' => $girlyPediaItems], 200);
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

        // Simpan data GirlyPedia dengan ID pengguna yang terautentikasi
        $girlyPediaItem = GirlyPedia::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return response()->json(['message' => 'GirlyPedia item created successfully!', 'data' => $girlyPediaItem], 201);
    }

    public function show($id)
    {
        // Ambil item GirlyPedia berdasarkan ID dan user_id
        $girlyPediaItem = GirlyPedia::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$girlyPediaItem) {
            return response()->json(['message' => 'GirlyPedia item not found or access denied.'], 404);
        }

        return response()->json(['message' => 'Data retrieved successfully', 'data' => $girlyPediaItem], 200);
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

        // Cari item GirlyPedia berdasarkan ID dan user_id
        $girlyPediaItem = GirlyPedia::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$girlyPediaItem) {
            return response()->json(['message' => 'GirlyPedia item not found or access denied.'], 404);
        }

        // Update data
        $girlyPediaItem->update($request->all());

        return response()->json(['message' => 'GirlyPedia item updated successfully!', 'data' => $girlyPediaItem], 200);
    }

    public function destroy($id)
    {
        // Hanya admin yang dapat menghapus data
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Cari item GirlyPedia berdasarkan ID dan user_id
        $girlyPediaItem = GirlyPedia::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$girlyPediaItem) {
            return response()->json(['message' => 'GirlyPedia item not found or access denied.'], 404);
        }

        $girlyPediaItem->delete();

        return response()->json(['message' => 'GirlyPedia item deleted successfully!'], 200);
    }
}
