@extends('layouts.admin')

@section('title', 'Profil Admin')
@section('subtitle', 'Kelola informasi akun dan keamanan login Anda.')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left: Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden">
            <!-- Gradient Banner -->
            <div class="h-24 bg-gradient-to-r from-primary-darker to-primary"></div>
            <!-- Avatar -->
            <div class="px-6 pb-6 flex flex-col items-center -mt-12 text-center">
                <div class="w-24 h-24 rounded-full bg-white border-4 border-white shadow-md flex items-center justify-center">
                    <div class="w-full h-full rounded-full bg-primary/20 flex items-center justify-center">
                        <span class="text-3xl font-bold text-primary">A</span>
                    </div>
                </div>
                <h3 class="mt-4 text-xl font-bold text-on-surface">Super Admin</h3>
                <p class="text-sm text-on-surface-variant">admin@ecotrash.com</p>
                <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20">
                    <span class="material-symbols-outlined text-[14px] mr-1">shield</span> Administrator
                </span>
            </div>
            <div class="border-t border-outline px-6 py-4">
                <div class="flex flex-col gap-3 text-sm">
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                        <span>Bergabung: 1 Januari 2026</span>
                    </div>
                    <div class="flex items-center gap-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[18px]">login</span>
                        <span>Login Terakhir: Hari ini, 08:30 WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Forms -->
    <div class="lg:col-span-2 flex flex-col gap-6">

        <!-- Form Informasi Akun -->
        <div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline">
                <h3 class="text-lg font-bold text-on-surface">Informasi Akun</h3>
                <p class="text-sm text-on-surface-variant mt-1">Perbarui nama tampilan dan informasi kontak.</p>
            </div>
            <div class="p-6">
                <form class="flex flex-col gap-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-on-surface mb-1">Nama Tampilan</label>
                            <input type="text" value="Super Admin" class="w-full px-4 py-2.5 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-on-surface mb-1">Email Login</label>
                            <input type="email" value="admin@ecotrash.com" class="w-full px-4 py-2.5 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                    <div class="flex justify-end pt-2 border-t border-outline">
                        <button type="button" @click="$dispatch('show-toast', { message: '✅ Informasi akun berhasil diperbarui!', type: 'success' })" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg font-bold text-sm transition-colors">Simpan Informasi</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Form Ganti Password -->
        <div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden">
            <div class="p-6 border-b border-outline">
                <h3 class="text-lg font-bold text-on-surface">Keamanan & Password</h3>
                <p class="text-sm text-on-surface-variant mt-1">Ganti password secara berkala untuk keamanan akun.</p>
            </div>
            <div class="p-6">
                <form class="flex flex-col gap-5">
                    <div>
                        <label class="block font-medium text-sm text-on-surface mb-1">Password Lama</label>
                        <input type="password" placeholder="Masukkan password lama" class="w-full px-4 py-2.5 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-on-surface mb-1">Password Baru</label>
                            <input type="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-2.5 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-on-surface mb-1">Konfirmasi Password Baru</label>
                            <input type="password" placeholder="Ulangi password baru" class="w-full px-4 py-2.5 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                        </div>
                    </div>
                    <div class="bg-surface-dim p-3 rounded-lg border border-outline text-xs text-on-surface-variant flex gap-2">
                        <span class="material-symbols-outlined text-[16px] shrink-0 mt-0.5">info</span>
                        Password harus minimal 8 karakter dan mengandung kombinasi huruf besar, huruf kecil, dan angka.
                    </div>
                    <div class="flex justify-end pt-2 border-t border-outline">
                        <button type="button" @click="$dispatch('show-toast', { message: '✅ Password berhasil diperbarui!', type: 'success' })" class="bg-primary hover:bg-primary-dark text-white px-6 py-2.5 rounded-lg font-bold text-sm transition-colors">Ganti Password</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
