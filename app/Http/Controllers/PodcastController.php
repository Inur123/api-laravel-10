<?php

namespace App\Http\Controllers;

use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PodcastController extends Controller
{
    public function index()
    {
        // Ambil semua item podcast
        $podcasts = Podcast::all();

        return view('podcasts.index', compact('podcasts'));
    }

    public function create()
    {
        // Pastikan hanya admin yang dapat mengakses halaman ini
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('podcasts.index')->with('error', 'Unauthorized');
        }

        // Menampilkan form untuk membuat podcast baru
        return view('podcasts.create');
    }

    public function store(Request $request)
    {
        // Hanya admin yang dapat menambah data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('podcasts.index')->with('error', 'Unauthorized');
        }

        // Validasi data yang diterima
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'required|url',
        ]);

        // Simpan data podcast dengan ID pengguna yang terautentikasi
        $podcast = Podcast::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        return redirect()->route('podcasts.index')->with('success', 'Podcast created successfully!');
    }

    public function show($id)
    {
        // Ambil item podcast berdasarkan ID
        $podcast = Podcast::find($id);

        if (!$podcast) {
            return redirect()->route('podcasts.index')->with('error', 'Podcast not found.');
        }

        return view('podcasts.show', compact('podcast'));
    }

    public function edit($id)
    {
        // Pastikan hanya admin yang dapat mengakses halaman ini
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('podcasts.index')->with('error', 'Unauthorized');
        }

        // Cari item podcast berdasarkan ID
        $podcast = Podcast::find($id);

        if (!$podcast) {
            return redirect()->route('podcasts.index')->with('error', 'Podcast not found.');
        }

        return view('podcasts.edit', compact('podcast'));
    }

    public function update(Request $request, $id)
    {
        // Hanya admin yang dapat mengupdate data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('podcasts.index')->with('error', 'Unauthorized');
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
            return redirect()->route('podcasts.index')->with('error', 'Podcast not found.');
        }

        // Update data
        $podcast->update($request->all());

        return redirect()->route('podcasts.index')->with('success', 'Podcast updated successfully!');
    }

    public function destroy($id)
    {
        // Hanya admin yang dapat menghapus data
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('podcasts.index')->with('error', 'Unauthorized');
        }

        // Cari item podcast berdasarkan ID
        $podcast = Podcast::find($id);

        if (!$podcast) {
            return redirect()->route('podcasts.index')->with('error', 'Podcast not found.');
        }

        $podcast->delete();

        return redirect()->route('podcasts.index')->with('success', 'Podcast deleted successfully!');
    }
}
