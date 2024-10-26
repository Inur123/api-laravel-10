<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\DailyTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyTaskController extends Controller
{
    // Menampilkan daftar daily tasks
    public function index()
    {
        $dailyTasks = DailyTask::with('challenge')->get(); // Ambil semua daily tasks beserta challenge terkait
        return view('daily_task.index', compact('dailyTasks'));
    }

    // Menampilkan form untuk membuat daily task baru
    public function create()
    {
        // Ambil semua challenge untuk ditampilkan di dropdown
        $challenges = Challenge::all();
        return view('daily_task.create', compact('challenges'));
    }

    // Menyimpan daily task baru
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'challenge_id' => 'required|exists:challenges,id', // Validasi challenge_id
            'description' => 'required|string|max:255', // Ubah validasi untuk description
        ]);

        // Membuat daily task baru
        DailyTask::create($validatedData);

        return redirect()->route('daily_tasks.index')->with('success', 'Daily task created successfully!');
    }

    // Menampilkan form untuk mengedit daily task
    public function edit(DailyTask $dailyTask)
    {
        // Ambil semua challenge untuk ditampilkan di dropdown
        $challenges = Challenge::all();
        return view('daily_task.edit', compact('dailyTask', 'challenges'));
    }

    // Memperbarui daily task
    public function update(Request $request, DailyTask $dailyTask)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'challenge_id' => 'required|exists:challenges,id', // Validasi challenge_id
            'description' => 'required|string|max:255', // Ubah validasi untuk description
        ]);

        // Memperbarui daily task
        $dailyTask->update($validatedData);

        return redirect()->route('daily_tasks.index')->with('success', 'Daily task updated successfully!');
    }

    // Menghapus daily task
    public function destroy(DailyTask $dailyTask)
    {
        // Menghapus daily task
        $dailyTask->delete();

        return redirect()->route('daily_tasks.index')->with('success', 'Daily task deleted successfully!');
    }
}
