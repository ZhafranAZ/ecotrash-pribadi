@extends('layouts.admin')

@section('title', 'Laporan Sampah Liar')
@section('subtitle', 'Kelola dan verifikasi laporan tumpukan sampah dari warga.')

@section('content')
<div x-data="laporanAdmin()" x-cloak>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 text-red-700">
            <span class="material-symbols-outlined text-red-500">error</span>
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden flex flex-col mb-8">
        <!-- Header/Filter -->
        <div class="p-4 border-b border-outline flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex gap-2">
                <select name="status" onchange="this.form.submit()" class="border border-outline rounded-lg px-3 py-2 text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="sedang_dibersihkan" {{ request('status') == 'sedang_dibersihkan' ? 'selected' : '' }}>Sedang Dibersihkan</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="relative">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID atau nama pelapor..." class="pl-9 pr-4 py-2 border border-outline rounded-lg text-sm w-full sm:w-64 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline">
                        <th class="py-3 px-4 font-semibold">ID Laporan</th>
                        <th class="py-3 px-4 font-semibold">Tanggal</th>
                        <th class="py-3 px-4 font-semibold">Pelapor</th>
                        <th class="py-3 px-4 font-semibold">Lokasi</th>
                        <th class="py-3 px-4 font-semibold">Foto</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($laporans as $laporan)
                        <tr class="border-b border-outline hover:bg-surface-variant/50 transition-colors">
                            <td class="py-3 px-4 text-on-surface font-medium">#LP-{{ $laporan->created_at->format('Ymd') }}-{{ str_pad($laporan->id, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-4 text-on-surface-variant">{{ $laporan->created_at->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-4 text-on-surface">{{ $laporan->warga->nama ?? '-' }}</td>
                            <td class="py-3 px-4 text-on-surface-variant truncate max-w-[150px]">{{ $laporan->alamat_lokasi ?? $laporan->lat . ', ' . $laporan->lng }}</td>
                            <td class="py-3 px-4">
                                @if($laporan->foto_laporan_warga)
                                    <img src="{{ asset('storage/' . $laporan->foto_laporan_warga) }}" alt="Foto Laporan" class="w-10 h-10 object-cover rounded border border-outline cursor-pointer" @click="openModal({{ $laporan->id }})">
                                @else
                                    <div class="w-10 h-10 bg-surface-variant rounded flex items-center justify-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[20px]">image</span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @switch($laporan->status)
                                    @case('menunggu')
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-50 text-yellow-700 ring-1 ring-inset ring-yellow-600/20">Menunggu</span>
                                        @break
                                    @case('disetujui')
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">Disetujui</span>
                                        @break
                                    @case('ditolak')
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/10">Ditolak</span>
                                        @break
                                    @case('sedang_dibersihkan')
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20">Sedang Dibersihkan</span>
                                        @break
                                    @case('selesai')
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Selesai</span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20">{{ ucfirst($laporan->status) }}</span>
                                @endswitch
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button @click="openModal({{ $laporan->id }})" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors" title="Lihat Detail">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="hover:bg-transparent">
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[48px] opacity-40">inbox</span>
                                    <p class="font-medium">Belum ada laporan masuk</p>
                                    <p class="text-sm">Laporan dari warga akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($laporans->hasPages())
            <div class="p-4 border-t border-outline">
                {{ $laporans->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Detail Laporan -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/50" @click="closeModal()"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface" x-text="'Detail Laporan #LP-' + selectedLaporan.ticketId"></h3>
                        <button @click="closeModal()" class="text-on-surface-variant hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
                    </div>

                    <!-- Default View -->
                    <div x-show="!isApproving && !isRejecting && !isMerging">
                        <div class="w-full h-48 bg-surface-variant rounded-lg border border-outline relative overflow-hidden mb-4 z-10">
                            <div :id="'admin-map-' + selectedLaporan.id" class="w-full h-full"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                            <div><p class="text-on-surface-variant font-medium">Pelapor</p><p class="text-on-surface font-semibold" x-text="selectedLaporan.pelapor"></p></div>
                            <div><p class="text-on-surface-variant font-medium">Tanggal</p><p class="text-on-surface font-semibold" x-text="selectedLaporan.tanggal"></p></div>
                            <div class="col-span-2"><p class="text-on-surface-variant font-medium">Titik Lokasi</p><p class="text-on-surface font-semibold" x-text="selectedLaporan.lokasi"></p></div>
                            <div class="col-span-2">
                                <p class="text-on-surface-variant font-medium">Foto Laporan</p>
                                <template x-if="selectedLaporan.foto">
                                    <img :src="selectedLaporan.foto" alt="Foto Laporan" class="w-full h-40 object-cover rounded-lg border border-outline mt-1">
                                </template>
                            </div>
                            <div class="col-span-2">
                                <p class="text-on-surface-variant font-medium">Deskripsi Warga</p>
                                <p class="text-on-surface bg-surface-dim p-3 rounded-lg border border-outline mt-1" x-text="selectedLaporan.deskripsi"></p>
                            </div>
                            <template x-if="selectedLaporan.status !== 'menunggu'">
                                <div class="col-span-2">
                                    <p class="text-on-surface-variant font-medium">Status</p>
                                    <div class="mt-1">
                                        <template x-if="selectedLaporan.status === 'disetujui' || selectedLaporan.status === 'sedang_dibersihkan'">
                                            <div class="bg-primary/10 border border-primary/20 p-3 rounded-lg flex items-center gap-2">
                                                <span class="material-symbols-outlined text-primary">engineering</span>
                                                <div>
                                                    <p class="text-primary-dark font-bold" x-text="selectedLaporan.status === 'sedang_dibersihkan' ? 'Sedang Dibersihkan' : 'Disetujui'"></p>
                                                    <p class="text-[10px] text-primary" x-show="selectedLaporan.petugas" x-text="'Petugas: ' + selectedLaporan.petugas"></p>
                                                </div>
                                            </div>
                                        </template>
                                        <template x-if="selectedLaporan.status === 'ditolak'">
                                            <div class="bg-red-50 border border-red-200 p-3 rounded-lg flex items-center gap-2">
                                                <span class="material-symbols-outlined text-red-500">cancel</span>
                                                <div>
                                                    <p class="text-red-700 font-bold">Ditolak</p>
                                                    <p class="text-[10px] text-red-600" x-show="selectedLaporan.alasanPenolakan" x-text="'Alasan: ' + selectedLaporan.alasanPenolakan"></p>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <template x-if="selectedLaporan.status === 'menunggu'">
                            <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                                <button @click="isApproving = true" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-primary text-sm font-bold text-white hover:bg-primary-dark sm:w-auto">Setujui Laporan</button>
                                <button @click="isMerging = true" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-amber-500 text-sm font-bold text-white hover:bg-amber-600 sm:w-auto">Tandai Duplikat</button>
                                <button @click="isRejecting = true" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-red-50 text-sm font-bold text-red-700 hover:bg-red-100 border border-red-200 sm:w-auto">Tolak Laporan</button>
                            </div>
                        </template>
                    </div>

                    <!-- Approve Form -->
                    <div x-show="isApproving" style="display: none;">
                        <form :action="'{{ url('admin/laporan') }}/' + selectedLaporan.id + '/approve'" method="POST">
                            @csrf
                            <div class="bg-primary/10 p-3 rounded-lg mb-4 flex gap-2 text-sm text-primary-dark">
                                <span class="material-symbols-outlined text-primary text-[18px] shrink-0 mt-0.5">info</span>
                                Tugaskan petugas dan tentukan koin bonus sebelum mengkonfirmasi persetujuan.
                            </div>
                            <div class="flex flex-col gap-4 mb-4">
                                <div>
                                    <label class="block font-medium text-sm text-on-surface mb-1">Tugaskan Petugas Lapangan</label>
                                    <select name="petugas_id" required class="w-full px-4 py-2 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                        <option value="">Pilih Petugas...</option>
                                        @foreach($petugasList as $petugas)
                                            <option value="{{ $petugas->id }}">{{ $petugas->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-on-surface mb-1">Koin Bonus untuk Pelapor</label>
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-yellow-500 text-[20px]">monetization_on</span>
                                        <input type="number" name="koin_reward" value="10" min="0" class="pl-10 pr-4 py-2 border border-outline rounded-lg w-full text-sm font-bold text-yellow-600 focus:border-primary focus:ring-1 focus:ring-primary outline-none">
                                    </div>
                                    <p class="text-xs text-on-surface-variant mt-1">Default 10 koin. Bisa disesuaikan.</p>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                                <button type="submit" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-primary text-sm font-bold text-white hover:bg-primary-dark sm:w-auto">Konfirmasi & Tugaskan</button>
                                <button type="button" @click="isApproving = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Kembali</button>
                            </div>
                        </form>
                    </div>

                    <!-- Reject Form -->
                    <div x-show="isRejecting" style="display: none;">
                        <form :action="'{{ url('admin/laporan') }}/' + selectedLaporan.id + '/reject'" method="POST">
                            @csrf
                            <div class="bg-red-50 p-3 rounded-lg mb-4 flex gap-2 text-sm text-red-700 border border-red-200">
                                <span class="material-symbols-outlined text-red-600 text-[18px] shrink-0 mt-0.5">warning</span>
                                Penolakan akan dikirimkan ke pelapor. Pastikan alasan penolakan jelas.
                            </div>
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-on-surface mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                                <textarea name="alasan_penolakan" rows="4" required minlength="5" placeholder="Contoh: Foto tidak jelas, lokasi tidak sesuai deskripsi, dsb." class="w-full px-4 py-2 border border-outline rounded-lg text-sm text-on-surface bg-white focus:border-red-400 focus:ring-1 focus:ring-red-400 outline-none resize-none"></textarea>
                            </div>
                            <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                                <button type="submit" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-red-600 text-sm font-bold text-white hover:bg-red-700 sm:w-auto">Konfirmasi Penolakan</button>
                                <button type="button" @click="isRejecting = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Kembali</button>
                            </div>
                        </form>
                    </div>

                    <!-- Merge/Duplikat Form -->
                    <div x-show="isMerging" style="display: none;">
                        <form :action="'{{ url('admin/laporan') }}/' + selectedLaporan.id + '/duplicate'" method="POST">
                            @csrf
                            <div class="bg-amber-50 p-3 rounded-lg mb-4 flex gap-2 text-sm text-amber-800 border border-amber-200">
                                <span class="material-symbols-outlined text-amber-600 text-[18px] shrink-0 mt-0.5">merge</span>
                                Laporan ini akan ditandai sebagai duplikat dan ditolak secara otomatis dengan alasan "Laporan Duplikat/Sudah dilaporkan oleh warga lain."
                            </div>
                            <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                                <button type="submit" class="w-full inline-flex justify-center rounded-lg px-4 py-2 bg-amber-500 text-sm font-bold text-white hover:bg-amber-600 sm:w-auto">Tandai Duplikat</button>
                                <button type="button" @click="isMerging = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Kembali</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Data laporan dari server (JSON) untuk digunakan Alpine
    const laporanData = @json($laporanJsonData);

    function laporanAdmin() {
        return {
            showModal: false,
            isApproving: false,
            isRejecting: false,
            isMerging: false,
            selectedLaporan: {},
            adminMap: null,

            openModal(id) {
                this.selectedLaporan = laporanData.find(l => l.id === id) || {};
                this.isApproving = false;
                this.isRejecting = false;
                this.isMerging = false;
                this.showModal = true;

                // Initialize or update Leaflet map after modal is visible
                this.$nextTick(() => {
                    setTimeout(() => {
                        const mapContainerId = 'admin-map-' + this.selectedLaporan.id;
                        const container = document.getElementById(mapContainerId);
                        if (!container) return;

                        // Destroy previous map instance if it exists on this container
                        if (container._leaflet_id) {
                            container._leaflet_map.remove();
                        }

                        const lat = this.selectedLaporan.lat || -6.200000;
                        const lng = this.selectedLaporan.lng || 106.816666;

                        const map = L.map(mapContainerId, { zoomControl: false }).setView([lat, lng], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OSM'
                        }).addTo(map);
                        L.marker([lat, lng]).addTo(map);

                        // Store reference for cleanup
                        container._leaflet_map = map;

                        setTimeout(() => map.invalidateSize(), 100);
                    }, 150);
                });
            },

            closeModal() {
                this.showModal = false;
            }
        };
    }
</script>
@endpush
@endsection
