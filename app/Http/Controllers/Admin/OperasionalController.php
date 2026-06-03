<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesananPengangkutan;
use App\Models\User;
use App\Models\Komplek;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OperasionalController extends Controller
{
    /**
     * Dashboard Operasional — Monitoring seluruh pesanan, digroup per komplek.
     */
    public function index(Request $request): View
    {
        // Filter parameters
        $tanggal = $request->input('tanggal', today()->toDateString());
        $statusFilter = $request->input('status');
        $komplekFilter = $request->input('komplek_id');

        // Query pesanan
        $query = PesananPengangkutan::with(['warga', 'petugas', 'komplek'])
            ->where('tanggal_penjemputan', $tanggal)
            ->orderBy('created_at', 'desc');

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($komplekFilter) {
            $query->where('komplek_id', $komplekFilter);
        }

        $pesanans = $query->get();

        // Group by komplek
        $pesananByKomplek = $pesanans->groupBy('komplek_id')->map(function ($group) {
            return [
                'komplek'  => $group->first()->komplek,
                'pesanans' => $group,
                // Ambil petugas yang ditugaskan di komplek ini
                'petugas'  => $group->first()->komplek
                    ->petugasUsers()
                    ->get(),
            ];
        });

        // Daftar semua komplek untuk filter dropdown
        $kompleks = Komplek::orderBy('nama_komplek')->get();
        $allPetugas = User::where('role', 'petugas')->where('status_kehadiran', 'aktif')->orderBy('nama')->get();

        $filters = [
            'tanggal'    => $tanggal,
            'status'     => $statusFilter,
            'komplek_id' => $komplekFilter,
        ];

        return view('admin.operasional.index', compact('pesananByKomplek', 'kompleks', 'allPetugas', 'filters'));
    }

    /**
     * Menugaskan petugas ke semua pesanan di sebuah komplek pada tanggal tertentu.
     */
    public function assignPetugas(Request $request)
    {
        $request->validate([
            'komplek_id' => 'required|exists:komplek,id',
            'tanggal'    => 'required|date',
            'petugas_id' => 'required|exists:users,id',
        ]);

        // Assign petugas_id ke semua pesanan yang belum selesai di komplek & tanggal tersebut
        PesananPengangkutan::where('komplek_id', $request->komplek_id)
            ->whereDate('tanggal_penjemputan', $request->tanggal)
            ->whereIn('status', ['menunggu_pembayaran', 'menunggu_pembayaran_selisih', 'menunggu'])
            ->update(['petugas_id' => $request->petugas_id]);

        // Attach ke pivot table petugas_komplek jika belum ada
        $komplek = Komplek::find($request->komplek_id);
        if (!$komplek->petugasUsers->contains($request->petugas_id)) {
            $komplek->petugasUsers()->attach($request->petugas_id);
        }

        return response()->json(['message' => 'Berhasil menugaskan petugas untuk komplek ini.']);
    }
}
