<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GirlyPedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GirlyPediaController extends Controller
{
    public function index()
    {
        // Retrieve all GirlyPedia items for the authenticated user
        $girlyPediaItems = GirlyPedia::where('user_id', Auth::id())->get();

        return response()->json(['message' => 'Data retrieved successfully', 'data' => $girlyPediaItems], 200);
    }

    public function store(Request $request)
    {
        // Only admin can add data
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate incoming data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Store image and save the path
        }

        // Save GirlyPedia data with authenticated user's ID
        $girlyPediaItem = GirlyPedia::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'image' => $imagePath, // Save the image path
        ]);

        return response()->json(['message' => 'GirlyPedia item created successfully!', 'data' => $girlyPediaItem], 201);
    }

    public function show($id)
    {
        // Retrieve GirlyPedia item by ID and user_id
        $girlyPediaItem = GirlyPedia::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$girlyPediaItem) {
            return response()->json(['message' => 'GirlyPedia item not found or access denied.'], 404);
        }

        return response()->json(['message' => 'Data retrieved successfully', 'data' => $girlyPediaItem], 200);
    }

    public function update(Request $request, $id)
    {
        // Only admin can update data
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate incoming data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation
        ]);

        // Retrieve the GirlyPedia item
        $girlyPediaItem = GirlyPedia::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$girlyPediaItem) {
            return response()->json(['message' => 'GirlyPedia item not found or access denied.'], 404);
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Optionally, you might want to delete the old image if necessary
            // Storage::disk('public')->delete($girlyPediaItem->image);

            $imagePath = $request->file('image')->store('images', 'public');
            $girlyPediaItem->image = $imagePath; // Update the image path
        }

        // Update other data
        $girlyPediaItem->update($request->except('image')); // Exclude the image from the request data

        return response()->json(['message' => 'GirlyPedia item updated successfully!', 'data' => $girlyPediaItem], 200);
    }

    public function destroy($id)
    {
        // Only admin can delete data
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Retrieve the GirlyPedia item
        $girlyPediaItem = GirlyPedia::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$girlyPediaItem) {
            return response()->json(['message' => 'GirlyPedia item not found or access denied.'], 404);
        }

        // Optionally, delete the image file from storage
        // Storage::disk('public')->delete($girlyPediaItem->image);

        $girlyPediaItem->delete();

        return response()->json(['message' => 'GirlyPedia item deleted successfully!'], 200);
    }
}
