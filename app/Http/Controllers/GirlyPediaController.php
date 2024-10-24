<?php

namespace App\Http\Controllers;

use App\Models\GirlyPedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GirlyPediaController extends Controller
{
    public function index()
    {
        // Retrieve all GirlyPedia items for authenticated users
        $girlyPediaItems = GirlyPedia::all();

        return view('girlyPedia.index', compact('girlyPediaItems'));
    }

    public function create()
    {
        // Ensure only admin can access this page
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        return view('girlyPedia.create');
    }

    public function store(Request $request)
    {
        // Only admin can add data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation
        ]);

        $girlyPediaItem = new GirlyPedia();
        $girlyPediaItem->title = $request->title;
        $girlyPediaItem->description = $request->description;
        $girlyPediaItem->link = $request->link;
        $girlyPediaItem->user_id = auth()->id(); // Add user_id

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Store image and get the path
            $girlyPediaItem->image = $imagePath; // Save the image path to the model
        }

        $girlyPediaItem->save();

        return redirect()->route('girlyPedia.index')->with('success', 'Item added successfully.');
    }

    public function show($id)
    {
        $girlyPediaItem = GirlyPedia::findOrFail($id);
        return view('girlyPedia.show', compact('girlyPediaItem'));
    }

    public function edit($id)
    {
        // Ensure only admin can access this page
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        $girlyPediaItem = GirlyPedia::findOrFail($id);
        return view('girlyPedia.edit', compact('girlyPediaItem'));
    }

    public function update(Request $request, $id)
    {
        // Only admin can update data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation
        ]);

        $girlyPediaItem = GirlyPedia::findOrFail($id);
        $girlyPediaItem->title = $request->title;
        $girlyPediaItem->description = $request->description;
        $girlyPediaItem->link = $request->link;

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Optionally, delete the old image if necessary
            if ($girlyPediaItem->image) {
                Storage::disk('public')->delete($girlyPediaItem->image); // Delete the old image
            }

            $imagePath = $request->file('image')->store('images', 'public'); // Store new image
            $girlyPediaItem->image = $imagePath; // Update image path
        }

        $girlyPediaItem->save(); // Save the updated item

        return redirect()->route('girlyPedia.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        // Only admin can delete data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        $girlyPediaItem = GirlyPedia::findOrFail($id);

        // Optionally, delete the image file from storage
        if ($girlyPediaItem->image) {
            Storage::disk('public')->delete($girlyPediaItem->image); // Delete the image
        }

        $girlyPediaItem->delete();

        return redirect()->route('girlyPedia.index')->with('success', 'Item deleted successfully!');
    }
}
