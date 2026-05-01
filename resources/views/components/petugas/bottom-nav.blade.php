<nav class="fixed bottom-0 w-full max-w-md mx-auto bg-surface border-t-2 border-outline pb-safe z-50 rounded-t-2xl">
    <div class="flex justify-around items-center h-16 px-2">
        <a href="{{ route('petugas.beranda') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('petugas.beranda') || request()->routeIs('petugas.tugas.*') ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[26px]" {!! request()->routeIs('petugas.beranda') || request()->routeIs('petugas.tugas.*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>home</span>
            <span class="text-[10px] font-bold">Aktif</span>
        </a>

        <a href="{{ route('petugas.riwayat') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('petugas.riwayat') ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[26px]" {!! request()->routeIs('petugas.riwayat') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>history</span>
            <span class="text-[10px] font-bold">Riwayat</span>
        </a>

        <a href="{{ route('petugas.profil') }}" class="flex flex-col items-center justify-center w-full h-full space-y-1 {{ request()->routeIs('petugas.profil') ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">
            <span class="material-symbols-outlined text-[26px]" {!! request()->routeIs('petugas.profil') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>person</span>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </div>
</nav>
