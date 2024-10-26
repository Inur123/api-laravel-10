<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    // Menampilkan daftar tantangan
    public function index()
    {
        $challenges = Challenge::all(); // Ambil semua tantangan
        return view('challenge.index', compact('challenges'));
    }

    // Menampilkan form untuk membuat tantangan baru
    public function create()
    {
        return view('challenge.create');
    }

    // Menyimpan tantangan baru
    public function store(Request $request)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('challenge.index')->with('error', 'Unauthorized');
        }

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Membuat tantangan baru
        $challenge = Challenge::create(array_merge($validatedData, ['user_id' => Auth::id()]));

        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully!');
    }

    // Menampilkan form untuk mengedit tantangan
    public function edit(Challenge $challenge)
    {
        return view('challenge.edit', compact('challenge'));
    }

    // Memperbarui tantangan
    public function update(Request $request, Challenge $challenge)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('challenges.index')->with('error', 'Unauthorized');
        }

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Memperbarui tantangan
        $challenge->update($validatedData);

        return redirect()->route('challenges.index')->with('success', 'Challenge updated successfully!');
    }

    // Menghapus tantangan
    public function destroy(Challenge $challenge)
    {
        // Check if the user is an admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('challenge.index')->with('error', 'Unauthorized');
        }

        // Menghapus tantangan
        $challenge->delete();

        return redirect()->route('challenges.index')->with('success', 'Challenge deleted successfully!');
    }
}
