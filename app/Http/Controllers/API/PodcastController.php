<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use App\Models\PodcastUser; // Make sure you have this model created
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

    public function markAsCompleted(Request $request, $id)
{
    // Validate the incoming request
    $request->validate([
        'is_completed' => 'required|boolean',
    ]);

    // Find the podcast item
    $podcastItem = Podcast::findOrFail($id);

    // Check if the relationship exists, and create if it doesn't
    $podcastUser = PodcastUser::firstOrCreate(
        ['user_id' => Auth::id(), 'podcast_id' => $podcastItem->id],
        ['is_completed' => false, 'progress' => 0] // Default values
    );

    // Update the completion status
    $podcastUser->is_completed = $request->is_completed; // Directly use the validated boolean value

    // Set progress based on completion status
    $podcastUser->progress = $request->is_completed ? 100 : 0;

    $podcastUser->save();

    // Calculate the new overall progress percentage for the user
    $this->updateProgress(Auth::id());

    return response()->json(['message' => 'Status updated successfully!', 'data' => $podcastUser], 200);
}

private function updateProgress($userId)
{
    // Get all podcast items for the user
    $podcastUsers = PodcastUser::where('user_id', $userId)->get();

    // Count total items and completed items
    $totalItems = $podcastUsers->count();
    $completedItems = $podcastUsers->where('is_completed', true)->count();

    // Calculate the progress percentage
    $progress = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;

    // Update progress for all related records
    foreach ($podcastUsers as $podcastUser) {
        $podcastUser->progress = $podcastUser->is_completed ? 100 : 0; // Set progress based on completion status
        $podcastUser->save();
    }

    // If you want to save the overall progress to the user profile or another related model, do it here.
}


}
