@extends('layouts.admin')

@section('title', 'Penjemputan Harian')
@section('subtitle', 'Pantau dan atur penugasan petugas untuk pesanan hari ini.')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div x-data="{
    showAssignModal: false,
    showDetailModal: false,
    selectedPesanan: null,
    assignKomplekId: null,
    assignKomplekNama: '',
    selectedPetugasId: '',
    isAssigning: false,
    assignSuccess: false
}">
    <!-- Filter/Action Bar -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.operasional.index') }}" class="flex items-center gap-2 bg-white px-4 py-2 border border-outline rounded-lg shadow-sm">
            <span class="material-symbols-outlined text-on-surface-variant text-[20px]">calendar_today</span>
            <input type="date" name="tanggal" value="{{ $filters['tanggal'] }}" 
                class="text-sm font-medium text-on-surface bg-transparent border-none focus:ring-0 p-0 cursor-pointer" 
                onchange="this.form.submit()">
            <span class="text-sm font-medium text-on-surface">{{ \Carbon\Carbon::parse($filters['tanggal'])->translatedFormat('d F Y') }}</span>
        </form>
        <div class="flex gap-2">
            <button class="bg-surface-variant hover:bg-outline text-on-surface px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">print</span> Cetak Manifes
            </button>
        </div>
    </div>

    @forelse($pesananByKomplek as $group)
    <!-- Komplek Group -->
    <div class="bg-white rounded-xl border border-outline shadow-sm mb-6 overflow-hidden">
        <div class="{{ $group['petugas']->count() > 0 ? 'bg-primary/5' : 'bg-red-50' }} p-4 border-b border-outline flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined {{ $group['petugas']->count() > 0 ? 'text-primary' : 'text-red-600' }} text-[24px]">location_city</span>
                <div>
                    <h3 class="font-bold text-lg {{ $group['petugas']->count() > 0 ? 'text-on-surface' : 'text-red-900' }}">{{ $group['komplek']->nama_komplek }}</h3>
                    <p class="text-sm {{ $group['petugas']->count() > 0 ? 'text-on-surface-variant' : 'text-red-700' }}">Total: {{ $group['pesanans']->count() }} Pesanan Hari Ini</p>
                </div>
            </div>
            @if($group['petugas']->count() > 0)
            <div class="flex items-center gap-3 bg-white px-3 py-1.5 rounded-lg border border-outline">
                <span class="text-sm text-on-surface-variant">Petugas:</span>
                <span class="text-sm font-semibold text-on-surface">{{ $group['petugas']->pluck('nama')->join(', ') }}</span>
                <button @click="assignKomplekId = {{ $group['komplek']->id }}; assignKomplekNama = '{{ $group['komplek']->nama_komplek }}'; selectedPetugasId = ''; showAssignModal = true" class="ml-2 text-primary hover:text-primary-dark text-sm underline">Ubah</button>
            </div>
            @else
            <div class="flex items-center gap-3 bg-white px-3 py-1.5 rounded-lg border border-red-200">
                <span class="text-sm text-red-600 font-medium">Petugas Belum Ditugaskan!</span>
                <button @click="assignKomplekId = {{ $group['komplek']->id }}; assignKomplekNama = '{{ $group['komplek']->nama_komplek }}'; selectedPetugasId = ''; showAssignModal = true" class="ml-2 bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-sm font-bold transition-colors">Tugaskan Sekarang</button>
            </div>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-dim text-on-surface-variant text-sm border-b border-outline">
                        <th class="py-3 px-4 font-semibold">Resi</th>
                        <th class="py-3 px-4 font-semibold">Pemesan</th>
                        <th class="py-3 px-4 font-semibold">Blok/Nomor</th>
                        <th class="py-3 px-4 font-semibold">Kategori</th>
                        <th class="py-3 px-4 font-semibold">Petugas</th>
                        <th class="py-3 px-4 font-semibold">Status</th>
                        <th class="py-3 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($group['pesanans'] as $pesanan)
                    <tr class="border-b border-outline hover:bg-surface-variant/50 transition-colors">
                        <td class="py-3 px-4 text-on-surface font-medium">{{ $pesanan->id }}</td>
                        <td class="py-3 px-4 text-on-surface">{{ $pesanan->warga->nama ?? '-' }}</td>
                        <td class="py-3 px-4 text-on-surface-variant">{{ $pesanan->blok_nomor_rumah }}</td>
                        <td class="py-3 px-4"><span class="bg-surface-variant px-2 py-1 rounded text-xs">{{ ucfirst($pesanan->kategori_sampah) }}</span></td>
                        <td class="py-3 px-4">
                            @if($pesanan->petugas)
                                <span class="text-on-surface font-medium">{{ $pesanan->petugas->nama }}</span>
                            @else
                                <span class="text-red-500 text-xs font-medium italic">Belum ditugaskan</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @php
                                $statusMap = [
                                    'menunggu_pembayaran' => ['label' => 'Menunggu Pembayaran', 'bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'ring' => 'ring-gray-600/20'],
                                    'menunggu_pembayaran_selisih' => ['label' => 'Bayar Selisih', 'bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'ring' => 'ring-orange-600/20'],
                                    'menunggu' => ['label' => 'Menunggu', 'bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'ring' => 'ring-gray-600/20'],
                                    'diproses' => ['label' => 'Diproses', 'bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'ring' => 'ring-yellow-600/20'],
                                    'selesai' => ['label' => 'Selesai', 'bg' => 'bg-green-50', 'text' => 'text-green-700', 'ring' => 'ring-green-600/20'],
                                    'dibatalkan' => ['label' => 'Dibatalkan', 'bg' => 'bg-red-50', 'text' => 'text-red-700', 'ring' => 'ring-red-600/20'],
                                    'hold_kapasitas' => ['label' => 'Hold Kapasitas', 'bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'ring' => 'ring-orange-600/20'],
                                    'gagal_pickup' => ['label' => 'Gagal Pickup', 'bg' => 'bg-red-50', 'text' => 'text-red-700', 'ring' => 'ring-red-600/20'],
                                ];
                                $s = $statusMap[$pesanan->status] ?? ['label' => $pesanan->status, 'bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'ring' => 'ring-gray-600/20'];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium {{ $s['bg'] }} {{ $s['text'] }} ring-1 ring-inset {{ $s['ring'] }}">{{ $s['label'] }}</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button @click="selectedPesanan = {
                                id: '{{ $pesanan->id }}',
                                warga: '{{ $pesanan->warga->nama ?? '-' }}',
                                alamat: '{{ $pesanan->nama_alamat_snapshot }}, {{ $pesanan->blok_nomor_rumah }}',
                                kategori: '{{ ucfirst($pesanan->kategori_sampah) }}',
                                catatan: '{{ addslashes($pesanan->catatan_warga ?? 'Tidak ada catatan.') }}',
                                status: '{{ $s['label'] }}',
                                statusRaw: '{{ $pesanan->status }}',
                                petugas: '{{ $pesanan->petugas->nama ?? 'Belum ditugaskan' }}',
                                koin: {{ $pesanan->koin_didapat ?? 0 }}
                            }; showDetailModal = true" class="text-primary hover:text-primary-dark p-1 rounded-md hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] opacity-40">inbox</span>
                                <p class="font-medium">Tidak ada pesanan di komplek ini hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <!-- Empty State -->
    <div class="bg-white rounded-xl border border-outline shadow-sm p-16 text-center">
        <div class="flex flex-col items-center gap-3 text-on-surface-variant">
            <span class="material-symbols-outlined text-[64px] opacity-40">inbox</span>
            <h3 class="text-lg font-bold text-on-surface">Tidak ada pesanan</h3>
            <p class="font-medium">Tidak ada pesanan pengangkutan untuk tanggal ini.</p>
        </div>
    </div>
    @endforelse

    <!-- Modal Tugaskan Petugas -->
    <div x-show="showAssignModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showAssignModal" x-transition.opacity class="fixed inset-0 bg-black/50" @click="showAssignModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 sm:p-0">
            <div x-show="showAssignModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-md w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface">Tugaskan Petugas</h3>
                        <button @click="showAssignModal = false"><span class="material-symbols-outlined text-on-surface-variant">close</span></button>
                    </div>
                    <p class="text-sm text-on-surface-variant mb-2">Komplek: <span class="font-semibold text-on-surface" x-text="assignKomplekNama"></span></p>
                    <p class="text-sm text-on-surface-variant mb-4">Pilih petugas untuk semua pesanan di komplek ini hari ini.</p>

                    <!-- Success message -->
                    <div x-show="assignSuccess" x-transition class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm font-medium flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Penugasan berhasil disimpan! Halaman akan di-refresh.
                    </div>

                    <div class="flex flex-col gap-2">
                        @foreach($allPetugas as $ptgs)
                        <label class="flex items-center justify-between p-3 border border-outline rounded-lg cursor-pointer hover:bg-surface-variant/50 transition-colors"
                            :class="selectedPetugasId == '{{ $ptgs->id }}' ? 'border-primary bg-primary/5 ring-1 ring-primary' : ''">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="petugas_radio" value="{{ $ptgs->id }}" x-model="selectedPetugasId" class="w-4 h-4 text-primary">
                                <div>
                                    <p class="text-sm font-semibold">{{ $ptgs->nama }}</p>
                                    <p class="text-xs {{ $ptgs->status_kehadiran === 'aktif' ? 'text-green-600' : 'text-red-600' }} font-medium">{{ ucfirst($ptgs->status_kehadiran) }}</p>
                                </div>
                            </div>
                            <span x-show="selectedPetugasId == '{{ $ptgs->id }}'" class="material-symbols-outlined text-primary text-[20px]">check_circle</span>
                        </label>
                        @endforeach

                        @if($allPetugas->isEmpty())
                        <div class="p-4 text-center text-on-surface-variant text-sm">
                            <span class="material-symbols-outlined text-[32px] opacity-40 mb-2">person_off</span>
                            <p>Belum ada petugas aktif yang terdaftar.</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="bg-surface-dim px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2 border-t border-outline">
                    <button
                        :disabled="!selectedPetugasId || isAssigning"
                        :class="!selectedPetugasId ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary-dark'"
                        @click="
                            isAssigning = true;
                            axios.post('{{ route('admin.operasional.assignPetugas') }}', {
                                komplek_id: assignKomplekId,
                                tanggal: '{{ $filters['tanggal'] }}',
                                petugas_id: selectedPetugasId
                            }, {
                                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                            }).then(r => {
                                isAssigning = false;
                                assignSuccess = true;
                                setTimeout(() => { window.location.reload(); }, 1200);
                            }).catch(e => {
                                isAssigning = false;
                                alert(e.response?.data?.message || 'Gagal menugaskan petugas.');
                            });
                        "
                        class="w-full inline-flex justify-center items-center gap-2 rounded-lg px-4 py-2 bg-primary text-sm font-bold text-white sm:w-auto transition-colors">
                        <span x-show="isAssigning" class="animate-spin material-symbols-outlined text-[18px]">progress_activity</span>
                        <span x-text="isAssigning ? 'Menyimpan...' : 'Simpan Penugasan'"></span>
                    </button>
                    <button @click="showAssignModal = false; assignSuccess = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pesanan -->
    <div x-show="showDetailModal && selectedPesanan" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div x-show="showDetailModal" x-transition.opacity class="fixed inset-0 bg-black/50" @click="showDetailModal = false"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 sm:p-0">
            <div x-show="showDetailModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative bg-white rounded-xl text-left overflow-hidden shadow-xl sm:my-8 sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg leading-6 font-bold text-on-surface">Detail Pesanan <span x-text="selectedPesanan?.id"></span></h3>
                        <button @click="showDetailModal = false"><span class="material-symbols-outlined text-on-surface-variant">close</span></button>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                        <div><p class="text-on-surface-variant font-medium">Pemesan</p><p class="text-on-surface font-semibold" x-text="selectedPesanan?.warga"></p></div>
                        <div>
                            <p class="text-on-surface-variant font-medium">Status Saat Ini</p>
                            <span x-text="selectedPesanan?.status"
                                :class="{
                                    'text-green-700': selectedPesanan?.statusRaw === 'selesai',
                                    'text-yellow-700': selectedPesanan?.statusRaw === 'diproses',
                                    'text-red-700': selectedPesanan?.statusRaw === 'gagal_pickup' || selectedPesanan?.statusRaw === 'dibatalkan',
                                    'text-orange-700': selectedPesanan?.statusRaw === 'hold_kapasitas',
                                    'text-gray-600': selectedPesanan?.statusRaw === 'menunggu_pembayaran',
                                    'text-on-surface-variant': selectedPesanan?.statusRaw === 'menunggu'
                                }"
                                class="font-semibold text-sm"></span>
                        </div>
                        <div class="col-span-2"><p class="text-on-surface-variant font-medium">Alamat Spesifik</p><p class="text-on-surface font-semibold" x-text="selectedPesanan?.alamat"></p></div>
                        <div><p class="text-on-surface-variant font-medium">Kategori Ukuran</p><p class="text-on-surface font-semibold" x-text="selectedPesanan?.kategori"></p></div>
                        <div><p class="text-on-surface-variant font-medium">Petugas</p><p class="text-on-surface font-semibold" x-text="selectedPesanan?.petugas"></p></div>
                        <div class="col-span-2">
                            <p class="text-on-surface-variant font-medium">Catatan Warga</p>
                            <p class="text-on-surface bg-surface-dim p-3 rounded-lg border border-outline mt-1" x-text="selectedPesanan?.catatan"></p>
                        </div>
                    </div>

                    <!-- Close button -->
                    <div class="flex flex-col sm:flex-row-reverse gap-2 border-t border-outline pt-4">
                        <button @click="showDetailModal = false" class="w-full inline-flex justify-center rounded-lg px-4 py-2 border border-outline text-sm font-bold text-on-surface hover:bg-surface-variant sm:w-auto">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
