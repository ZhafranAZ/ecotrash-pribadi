<x-petugas-layout>
    <div x-data="{ 
        fotoPreview: '{{ $petugas->foto_profil ? asset('storage/' . $petugas->foto_profil) : '' }}',
        handleFile(e) {
            if(e.target.files.length > 0){
                const file = e.target.files[0];
                this.fotoPreview = URL.createObjectURL(file);
                
                let fd = new FormData();
                fd.append('foto', file);
                
                axios.post('{{ route('petugas.profil.uploadFoto') }}', fd, {
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(r => {
                    window.location.reload();
                }).catch(err => {
                    alert(err.response?.data?.message || 'Gagal mengunggah foto');
                });
            }
        },
        showDaruratModal: false, 
        daruratState: 'form', // 'form' -> 'success'
        showLogoutModal: false,
        alasan: '',
        isLoading: false,
        laporBerhalangan() {
            if (this.alasan.trim().length < 5) {
                alert('Alasan berhalangan minimal 5 karakter.');
                return;
            }
            this.isLoading = true;
            axios.post('{{ route('petugas.profil.berhalangan') }}', { alasan: this.alasan }, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
            }).then(r => {
                this.daruratState = 'success';
                this.isLoading = false;
            }).catch(err => {
                alert(err.response?.data?.message || 'Gagal mengirim laporan');
                this.isLoading = false;
            });
        },
        aktifkanKembali() {
            if (confirm('Apakah Anda yakin ingin mengaktifkan kembali status Anda dan siap bertugas?')) {
                axios.post('{{ route('petugas.profil.aktif') }}', {}, {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                }).then(r => {
                    window.location.reload();
                }).catch(err => {
                    alert(err.response?.data?.message || 'Gagal mengaktifkan kembali');
                });
            }
        }
    }">
        <!-- Header -->
        <header class="bg-surface border-b border-outline px-4 pt-6 pb-4 sticky top-0 z-30">
            <h1 class="text-xl font-black text-on-surface">Profil Petugas</h1>
        </header>

        <div class="px-4 py-6 pb-24 space-y-6">
            
            <!-- Profile Card -->
            <div class="glass-card rounded-3xl p-6 text-center relative overflow-hidden">
                <div class="relative w-24 h-24 mx-auto mb-4">
                    <template x-if="!fotoPreview">
                        <div class="w-full h-full rounded-full bg-primary/20 text-primary flex items-center justify-center border-4 border-white shadow-sm">
                            <span class="material-symbols-outlined text-[48px]">account_circle</span>
                        </div>
                    </template>
                    <template x-if="fotoPreview">
                        <img :src="fotoPreview" class="w-full h-full rounded-full object-cover border-4 border-white shadow-sm">
                    </template>
                    
                    <label for="foto_profil" class="absolute bottom-0 right-0 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:bg-primary-dark transition-colors border-2 border-white">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                    </label>
                    <input type="file" id="foto_profil" accept="image/*" class="hidden" @change="handleFile">
                </div>
                <h2 class="text-xl font-black text-on-surface mb-1">{{ $petugas->nama }}</h2>
                <p class="text-sm font-bold text-on-surface-variant">ID: PTG-{{ date('Y') }}-{{ str_pad($petugas->id, 3, '0', STR_PAD_LEFT) }}</p>
                
                <div class="flex items-center justify-center gap-2 mt-4 inline-flex bg-primary/10 px-4 py-2 rounded-full">
                    <span class="material-symbols-outlined text-[16px] text-primary">mail</span>
                    <span class="text-xs font-bold text-primary">{{ $petugas->email }}</span>
                </div>

                <!-- Background Accents -->
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-primary/5 rounded-full blur-2xl -z-10"></div>
                <div class="absolute -left-8 -bottom-8 w-32 h-32 bg-primary/5 rounded-full blur-2xl -z-10"></div>
            </div>

            <!-- Area Tugas Aktif -->
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Area Tugas Aktif</p>
                <div class="bg-surface border border-outline rounded-2xl p-4 flex flex-wrap gap-2">
                    @forelse($petugas->petugasKomplek as $komplek)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold">
                            <span class="material-symbols-outlined text-[14px]">holiday_village</span>
                            {{ $komplek->nama_komplek }}
                        </span>
                    @empty
                        <span class="text-xs font-bold text-on-surface-variant/70 p-1">Belum ditugaskan di komplek manapun.</span>
                    @endforelse
                </div>
            </div>

            <!-- Emergency Action / Attendance Status -->
            <div>
                @if($petugas->status_kehadiran === 'berhalangan')
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Status Kehadiran</p>
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center space-y-4">
                        <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto">
                            <span class="material-symbols-outlined text-[32px]">warning</span>
                        </div>
                        <div>
                            <h3 class="font-black text-red-600 text-lg">Anda Sedang Berhalangan</h3>
                            <p class="text-xs font-medium text-red-600/80 mt-1">Status Kehadiran Anda saat ini diatur sebagai Berhalangan/Offline.</p>
                            <div class="mt-3 bg-white/60 rounded-xl p-3 text-left border border-red-100">
                                <p class="text-[10px] font-bold text-red-500 uppercase tracking-wider">Alasan:</p>
                                <p class="text-xs font-semibold text-on-surface mt-0.5">{{ $petugas->alasan_berhalangan ?? 'Tidak ada alasan spesifik.' }}</p>
                            </div>
                        </div>
                        <button @click="aktifkanKembali" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                            Aktifkan Kembali & Siap Bertugas
                        </button>
                    </div>
                @else
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Laporan Darurat</p>
                    <button @click="showDaruratModal = true" class="w-full bg-red-50 border border-red-200 rounded-2xl p-4 flex items-center justify-between hover:bg-red-100 transition-colors active:scale-[0.98]">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[24px]">medical_services</span>
                            </div>
                            <div class="text-left">
                                <p class="font-bold text-red-600">Lapor Sakit / Kecelakaan</p>
                                <p class="text-[10px] font-medium text-red-600/80 mt-0.5">Ubah status jadi berhalangan.</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-red-600">chevron_right</span>
                    </button>
                @endif
            </div>

            <!-- System Settings -->
            <div>
                <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3 px-2">Sistem</p>
                
                <button @click="showLogoutModal = true" class="w-full bg-surface border border-outline rounded-2xl p-4 flex items-center justify-between hover:bg-surface-variant transition-colors active:scale-[0.98]">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface shrink-0">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                        </div>
                        <p class="font-bold text-on-surface text-sm">Keluar Akun</p>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span>
                </button>
            </div>
        </div>

        <!-- Darurat Modal -->
        <div x-show="showDaruratModal" class="fixed inset-0 z-[60] overflow-hidden" style="display: none;">
            <div x-show="showDaruratModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showDaruratModal = false"
                 class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

            <div x-show="showDaruratModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-y-full"
                 x-transition:enter-end="translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="translate-y-0"
                 x-transition:leave-end="translate-y-full"
                 class="absolute bottom-0 w-full max-w-md left-1/2 -translate-x-1/2 bg-surface rounded-t-[2rem] shadow-2xl p-6 pb-safe border-t border-outline">
                
                <div class="w-12 h-1.5 bg-outline rounded-full mx-auto mb-6"></div>

                <div x-show="daruratState === 'form'">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]">medical_services</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-on-surface">Lapor Berhalangan</h3>
                            <p class="text-xs font-medium text-on-surface-variant mt-0.5">Tugasmu hari ini akan dialihkan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2 px-1">Alasan Berhalangan</label>
                            <textarea x-model="alasan" rows="3" class="w-full bg-surface border border-outline rounded-2xl p-4 text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-none" placeholder="Misal: Saya mengalami kecelakaan motor, atau sedang demam tinggi..."></textarea>
                        </div>
                        
                        <button @click="laporBerhalangan()" :disabled="isLoading" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-red-600/30 transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                            <span x-show="!isLoading" class="material-symbols-outlined text-[20px]">send</span>
                            <span x-show="isLoading" class="animate-spin material-symbols-outlined text-[20px]">progress_activity</span>
                            <span x-text="isLoading ? 'Mengirim...' : 'Kirim Laporan & Istirahat'"></span>
                        </button>
                        <button @click="showDaruratModal = false" :disabled="isLoading" class="w-full bg-surface border border-outline hover:bg-surface-variant text-on-surface font-bold py-3.5 rounded-xl transition-colors disabled:opacity-50">Batal</button>
                    </div>
                </div>

                <!-- State: Success -->
                <div x-show="daruratState === 'success'" style="display: none;" class="text-center py-4">
                    <div class="w-20 h-20 rounded-full bg-primary/20 text-primary flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-[40px]">check_circle</span>
                    </div>
                    <h3 class="text-xl font-black text-on-surface mb-2">Laporan Diterima</h3>
                    <p class="text-sm text-on-surface-variant mb-6 leading-relaxed">Status Anda sekarang diatur menjadi <span class="font-bold text-red-500">Berhalangan/Offline</span>. Pekerjaan hari ini telah dialihkan ke petugas lain. Semoga lekas membaik!</p>
                    <button @click="showDaruratModal = false; daruratState = 'form'; window.location.reload();" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 rounded-xl transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Keluar -->
        <div x-show="showLogoutModal" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div x-show="showLogoutModal" x-transition.opacity class="fixed inset-0 bg-black/50 transition-opacity" @click="showLogoutModal = false"></div>
            <div class="flex items-center justify-center min-h-screen px-4 text-center">
                <div x-show="showLogoutModal" x-transition.scale class="relative bg-surface rounded-3xl text-left overflow-hidden shadow-xl transform transition-all w-full max-w-sm">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-[32px]">logout</span>
                        </div>
                        <h3 class="text-lg font-black text-on-surface mb-2">Keluar Akun?</h3>
                        <p class="text-sm text-on-surface-variant mb-6">Anda harus masuk kembali menggunakan kredensial untuk dapat menerima tugas lagi.</p>
                        <div class="flex gap-3">
                            <button @click="showLogoutModal = false" class="flex-1 py-3 rounded-xl font-bold text-on-surface bg-surface-variant transition-colors">Batal</button>
                            <form method="POST" action="{{ route('logout') }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full py-3 rounded-xl font-bold text-white bg-red-600 hover:bg-red-700 shadow-lg shadow-red-600/30 transition-colors inline-flex justify-center items-center">Ya, Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-petugas-layout>
