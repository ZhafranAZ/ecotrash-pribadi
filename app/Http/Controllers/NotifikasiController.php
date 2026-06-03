<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Tandai semua notifikasi milik user yang sedang login sebagai sudah dibaca.
     * Dipanggil oleh tombol "Tandai Semua Dibaca" di dropdown lonceng.
     */
    public function markAllAsRead(Request $request)
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
