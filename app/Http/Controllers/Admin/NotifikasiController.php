<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of admin notifications.
     */
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'semua');
        $query = Notifikasi::where('user_id', Auth::id())->latest();

        if ($tab === 'unread') {
            $query->where('is_read', false);
        } elseif ($tab === 'penting') {
            $query->whereIn('tipe', ['warning', 'error']);
        }

        $notifikasis = $query->paginate(10)->withQueryString();

        return view('admin.notifikasi.index', compact('notifikasis', 'tab'));
    }
}
