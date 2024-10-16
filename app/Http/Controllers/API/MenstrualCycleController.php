<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MenstrualCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Simpan data siklus menstruasi
        $menstrualCycle = MenstrualCycle::create([
            'user_id' => Auth::id(),
            'cycle_duration' => $request->cycle_duration,
            'last_period_start' => $request->last_period_start,
            'gap_days' => $request->gap_days,
        ]);

        return response()->json(['message' => 'Menstrual cycle data stored successfully!', 'data' => $menstrualCycle], 201);
    }

    public function index()
    {
        // Ambil semua data siklus menstruasi untuk pengguna yang terautentikasi
        $cycles = MenstrualCycle::where('user_id', Auth::id())->get();
        return response()->json($cycles);
    }

    public function checkCycle(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'last_period_start' => 'required|date',
            'cycle_duration' => 'required|integer|min:4|max:14',
            'gap_days' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        // Ambil siklus menstruasi terakhir dari database
        $lastCycle = MenstrualCycle::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        // Menghitung tanggal seharusnya menstruasi berikutnya
        if ($lastCycle) {
            $nextExpectedDate = \Carbon\Carbon::parse($lastCycle->last_period_start)
                ->addDays($lastCycle->cycle_duration + $lastCycle->gap_days);

            $currentDate = \Carbon\Carbon::now();

            // Cek apakah ada keterlambatan
            if ($currentDate->greaterThan($nextExpectedDate)) {
                // Jika terjadi keterlambatan, kembalikan notifikasi dan URL GirlyPedia
                return response()->json([
                    'message' => 'Notifikasi: Terjadi keterlambatan menstruasi.',
                    'redirect_url' => url('/girlypedia'), // Ganti dengan URL halaman GirlyPedia
                ], 200);
            }
        }

        return response()->json(['message' => 'Siklus menstruasi dalam rentang normal.'], 200);
    }
}
