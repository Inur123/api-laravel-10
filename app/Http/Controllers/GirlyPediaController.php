<?php

namespace App\Http\Controllers;

use App\Models\GirlyPedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GirlyPediaController extends Controller
{
    public function index()
    {
        // Ambil semua item GirlyPedia untuk pengguna yang terautentikasi
        $girlyPediaItems = GirlyPedia::all();

        return view('girlyPedia.index', compact('girlyPediaItems'));
    }

    public function create()
    {
        // Pastikan hanya admin yang dapat mengakses halaman ini
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        return view('girlyPedia.create');
    }

    public function store(Request $request)
    {
        // Hanya admin yang dapat menambah data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
        ]);

        $girlyPediaItem = new GirlyPedia();
        $girlyPediaItem->title = $request->title;
        $girlyPediaItem->description = $request->description;
        $girlyPediaItem->link = $request->link;
        $girlyPediaItem->user_id = auth()->id(); // Menambahkan user_id
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
        // Pastikan hanya admin yang dapat mengakses halaman ini
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        $girlyPediaItem = GirlyPedia::findOrFail($id);
        return view('girlyPedia.edit', compact('girlyPediaItem'));
    }

    public function update(Request $request, $id)
    {
        // Hanya admin yang dapat mengupdate data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
        ]);

        $girlyPediaItem = GirlyPedia::findOrFail($id);
        $girlyPediaItem->update($request->all());

        return redirect()->route('girlyPedia.index')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        // Hanya admin yang dapat menghapus data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('girlyPedia.index')->with('error', 'Unauthorized');
        }

        $girlyPediaItem = GirlyPedia::findOrFail($id);
        $girlyPediaItem->delete();

        return redirect()->route('girlyPedia.index')->with('success', 'Item deleted successfully!');
    }
}
