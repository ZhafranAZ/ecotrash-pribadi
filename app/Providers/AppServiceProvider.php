<?php

namespace App\Providers;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer: Inject unread notifications ke semua view
        // Agar lambang lonceng di Navigation Bar berfungsi otomatis
        // tanpa perlu mengirim variabel dari masing-masing Controller.
        View::composer('*', function ($view) {
            if (Auth::check()) {
                static $unreadNotifications = null;
                static $unreadCount = null;
                static $absentPetugasInfo = null;

                if ($unreadNotifications === null) {
                    $unreadNotifications = Notifikasi::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->latest()
                        ->take(10)
                        ->get();
                }

                if ($unreadCount === null) {
                    $unreadCount = Notifikasi::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
                }

                if ($absentPetugasInfo === null) {
                    $absentPetugas = \App\Models\User::where('role', 'petugas')
                        ->where('status_kehadiran', 'berhalangan')
                        ->with('petugasKomplek')
                        ->first();
                    if ($absentPetugas) {
                        $komplekNames = $absentPetugas->petugasKomplek->pluck('nama_komplek')->implode(', ');
                        $absentPetugasInfo = [
                            'nama' => $absentPetugas->nama,
                            'komplek' => $komplekNames ?: 'Tidak ada area tugas',
                        ];
                    } else {
                        $absentPetugasInfo = false;
                    }
                }

                $view->with('unreadNotifications', $unreadNotifications);
                $view->with('unreadCount', $unreadCount);
                $view->with('absentPetugasInfo', $absentPetugasInfo);
            } else {
                $view->with('unreadNotifications', collect());
                $view->with('unreadCount', 0);
                $view->with('absentPetugasInfo', false);
            }
        });
    }
}
