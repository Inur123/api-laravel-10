<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MenstrualCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MenstrualCycleController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'cycle_duration' => 'required|integer|min:4|max:14',
            'last_period_start' => 'required|date',
            'gap_days' => 'required|integer|min:1',
        ]);

        // Hitung tanggal selesai berdasarkan durasi
        $lastPeriodFinish = Carbon::parse($request->last_period_start)->addDays($request->cycle_duration);

        // Simpan data siklus menstruasi
        $menstrualCycle = MenstrualCycle::create([
            'user_id' => Auth::id(),
            'cycle_duration' => $request->cycle_duration,
            'last_period_start' => $request->last_period_start,
            'last_period_finish' => $lastPeriodFinish->toDateString(),
            'is_completed' => false,
        ]);

        return response()->json(['message' => 'Menstrual cycle data stored successfully!', 'data' => $menstrualCycle], 201);
    }

    public function index()
    {
        // Ambil semua data siklus menstruasi untuk pengguna yang terautentikasi
        $cycles = MenstrualCycle::where('user_id', Auth::id())->get();

        return response()->json(['message' => 'Data retrieved successfully', 'data' => $cycles], 200);
    }

    public function checkCycle(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'cycle_duration' => 'required|integer|min:4|max:14',
            'last_period_start' => 'required|date',
            'gap_days' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        // Ambil siklus menstruasi terakhir dari database
        $lastCycle = MenstrualCycle::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Cek apakah siklus terakhir ada
        if ($lastCycle) {
            $currentDate = Carbon::now();
            $lastPeriodFinish = Carbon::parse($lastCycle->last_period_start)->addDays($lastCycle->cycle_duration + $lastCycle->gap_days);

            // Jika saat ini lebih besar dari tanggal siklus selesai
            if ($currentDate->greaterThan($lastPeriodFinish)) {
                // Tandai siklus sebagai selesai
                $lastCycle->update(['is_completed' => true]);

                return response()->json([
                    'message' => 'Siklus menstruasi telah selesai.',
                    'is_completed' => true,
                    'next_expected_start' => $lastPeriodFinish->toDateString(),
                ], 200);
            }

            // Jika masih di antara waktu mulai dan selesai
            if ($currentDate->between($lastCycle->last_period_start, $lastCycle->last_period_finish)) {
                return response()->json([
                    'message' => 'Siklus menstruasi masih berlangsung.',
                    'is_completed' => false,
                    'next_expected_start' => $lastPeriodFinish->toDateString(),
                ], 200);
            }
        }

        return response()->json(['message' => 'Data siklus menstruasi tidak ditemukan.'], 404);
    }

    public function update(Request $request)
{
    // Validasi data yang diterima
    $request->validate([
        'cycle_duration' => 'required|integer|min:4|max:14',
        'last_period_start' => 'required|date',
        'gap_days' => 'required|integer|min:1',
    ]);

    // Ambil siklus menstruasi terakhir berdasarkan user_id
    $menstrualCycle = MenstrualCycle::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->first();

    // Cek apakah siklus ditemukan dan dimiliki oleh pengguna
    if (!$menstrualCycle) {
        return response()->json(['message' => 'Siklus menstruasi tidak ditemukan atau tidak berhak mengakses.'], 404);
    }

    // Hitung tanggal selesai berdasarkan durasi dan update data
    $lastPeriodFinish = Carbon::parse($request->last_period_start)->addDays($request->cycle_duration);
    $menstrualCycle->update([
        'cycle_duration' => $request->cycle_duration,
        'last_period_start' => $request->last_period_start,
        'last_period_finish' => $lastPeriodFinish->toDateString(), // Simpan sebagai string
    ]);

    return response()->json(['message' => 'Menstrual cycle data updated successfully!', 'data' => $menstrualCycle], 200);
}


}
