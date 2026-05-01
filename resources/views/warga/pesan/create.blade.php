@extends('layouts.warga')

@section('title', 'Pesan Pengangkutan')

@section('header')
<div class="flex items-center gap-3 w-full">
    <a href="{{ route('warga.dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-surface-variant text-on-surface-variant transition-colors">
        <span class="material-symbols-outlined">arrow_back</span>
    </a>
    <span class="font-bold text-on-surface">Pesan Pengangkutan</span>
</div>
@endsection

@section('content')
<div class="md:bg-transparent min-h-[calc(100vh-120px)] md:min-h-0" x-data="{
    step: 1,
    kategori: 'Sedang',
    jadwal: '',
    saldo: 450,
    koin: 0,
    hargaBase: 25000,
    get totalHarga() { return this.hargaBase - (this.koin * 100); },
    showAddressModal: false,
    showAddAddressForm: false,
    isSuccess: false,
    addresses: [
        { id: 1, title: 'Rumah Utama', komplek: 'Bunga Asri', detail: 'Blok C2 No. 15, RT 04 RW 02' },
        { id: 2, title: 'Kantor', komplek: 'Griya Indah', detail: 'Gedung X Lt. 4, Sudirman' }
    ],
    selectedAddressId: 1,
    showEditAddressForm: false,
    editingAddress: { id: null, title: '', komplek: '', detail: '' },
    get selectedAddress() { 
        let addr = this.addresses.find(a => a.id === this.selectedAddressId) || this.addresses[0];
        return {
            title: addr.title + ' (Komplek ' + addr.komplek + ')',
            detail: addr.detail
        };
    },
    startEdit(addr) {
        this.editingAddress = { ...addr };
        this.showEditAddressForm = true;
    },
    saveEdit() {
        let index = this.addresses.findIndex(a => a.id === this.editingAddress.id);
        if (index !== -1) {
            this.addresses[index] = { ...this.editingAddress };
        }
        this.showEditAddressForm = false;
        showToast('Alamat berhasil diperbarui', 'success');
    },
    isPaying: false,
    processPayment() {
        this.isPaying = true;
        setTimeout(() => {
            window.location.href = '{{ route('warga.pesan.berhasil') }}';
        }, 2000);
    }
} ">
    <!-- Progress Bar (Mobile Only - on desktop we can use sidebar steps) -->
    <div class="px-6 py-4 border-b border-outline bg-surface-dim md:hidden">
        <div class="flex items-center justify-between relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-outline z-0"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-primary z-0 transition-all duration-300" :style="`width: ${(step-1)*50}%`"></div>
            
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold z-10 transition-colors" :class="step >= 1 ? 'bg-primary text-white' : 'bg-surface border-2 border-outline text-on-surface-variant'">1</div>
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold z-10 transition-colors" :class="step >= 2 ? 'bg-primary text-white' : 'bg-surface border-2 border-outline text-on-surface-variant'">2</div>
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold z-10 transition-colors" :class="step >= 3 ? 'bg-primary text-white' : 'bg-surface border-2 border-outline text-on-surface-variant'">3</div>
        </div>
        <div class="flex justify-between text-xs font-bold text-on-surface-variant mt-2 px-1">
            <span :class="step===1 ? 'text-primary':''">Kategori</span>
            <span :class="step===2 ? 'text-primary':''">Jadwal</span>
            <span :class="step===3 ? 'text-primary':''">Checkout</span>
        </div>
    </div>

    <div class="md:grid md:grid-cols-12 md:gap-8 md:items-start">
        
        <!-- Form Area -->
        <div class="md:col-span-8 space-y-6 bg-white md:p-8 md:rounded-3xl md:shadow-sm md:border md:border-outline">
            
            <!-- Desktop Steps Indicator -->
            <div class="hidden md:flex items-center gap-4 mb-8 pb-6 border-b border-outline">
                <button @click="step = 1" class="flex items-center gap-2" :class="step === 1 ? 'text-primary' : 'text-on-surface-variant hover:text-on-surface'">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors" :class="step === 1 ? 'bg-primary text-white shadow-md' : 'bg-surface border-2 border-outline'">1</span>
                    <span class="font-bold">Alamat & Kategori</span>
                </button>
                <div class="h-px bg-outline flex-1"></div>
                <button @click="step >= 1 ? step = 2 : null" class="flex items-center gap-2" :class="step === 2 ? 'text-primary' : (step > 2 ? 'text-on-surface hover:text-primary' : 'text-on-surface-variant cursor-not-allowed')">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors" :class="step === 2 ? 'bg-primary text-white shadow-md' : (step > 2 ? 'bg-primary/20 text-primary border-2 border-primary' : 'bg-surface border-2 border-outline')">2</span>
                    <span class="font-bold">Jadwal Jemput</span>
                </button>
                <div class="h-px bg-outline flex-1"></div>
                <button @click="step >= 2 && jadwal ? step = 3 : null" class="flex items-center gap-2" :class="step === 3 ? 'text-primary' : 'text-on-surface-variant cursor-not-allowed'">
                    <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-colors" :class="step === 3 ? 'bg-primary text-white shadow-md' : 'bg-surface border-2 border-outline'">3</span>
                    <span class="font-bold">Checkout</span>
                </button>
            </div>

            <!-- Step 1: Kategori & Alamat -->
            <div x-show="step === 1" 
                 x-transition:enter="transition transform ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="p-4 md:p-0 space-y-6">
                <div>
                    <h3 class="font-bold text-on-surface mb-3 md:text-lg">Alamat Pengambilan</h3>
                    <div @click="showAddressModal = true" class="border border-outline rounded-2xl p-4 md:p-5 flex gap-4 items-start bg-primary/5 hover:border-primary/50 transition-colors cursor-pointer group">
                        <span class="material-symbols-outlined text-primary text-[28px]">location_on</span>
                        <div>
                            <p class="font-bold text-sm md:text-base text-on-surface" x-text="selectedAddress.title"></p>
                            <p class="text-xs md:text-sm text-on-surface-variant mt-1" x-text="selectedAddress.detail"></p>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant ml-auto group-hover:text-primary transition-colors">edit</span>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-on-surface mb-3 md:text-lg mt-8">Estimasi Volume Sampah</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="border rounded-2xl p-5 flex md:flex-col items-center md:items-start md:justify-between gap-4 cursor-pointer transition-all hover:shadow-md" :class="kategori === 'Kecil' ? 'border-primary bg-primary/5 ring-2 ring-primary/20 shadow-sm' : 'border-outline hover:bg-surface-variant'">
                            <input type="radio" name="kategori" value="Kecil" x-model="kategori" class="hidden">
                            <span class="material-symbols-outlined text-[36px] md:mb-2" :class="kategori === 'Kecil' ? 'text-primary' : 'text-on-surface-variant'">shopping_bag</span>
                            <div class="flex-1 md:w-full">
                                <p class="font-bold text-sm md:text-base text-on-surface">Kecil</p>
                                <p class="text-xs text-on-surface-variant mt-1">1-2 Kantong Kresek</p>
                            </div>
                            <p class="text-sm font-bold text-on-surface md:mt-4 md:text-primary md:bg-white md:px-3 md:py-1 md:rounded-lg md:shadow-sm" x-show="kategori==='Kecil'">Rp15.000</p>
                        </label>
                        <label class="border rounded-2xl p-5 flex md:flex-col items-center md:items-start md:justify-between gap-4 cursor-pointer transition-all hover:shadow-md" :class="kategori === 'Sedang' ? 'border-primary bg-primary/5 ring-2 ring-primary/20 shadow-sm' : 'border-outline hover:bg-surface-variant'">
                            <input type="radio" name="kategori" value="Sedang" x-model="kategori" class="hidden">
                            <span class="material-symbols-outlined text-[36px] md:mb-2" :class="kategori === 'Sedang' ? 'text-primary' : 'text-on-surface-variant'">delete</span>
                            <div class="flex-1 md:w-full">
                                <p class="font-bold text-sm md:text-base text-on-surface">Sedang</p>
                                <p class="text-xs text-on-surface-variant mt-1">1 Tempat Sampah Penuh</p>
                            </div>
                            <p class="text-sm font-bold text-on-surface md:mt-4 md:text-primary md:bg-white md:px-3 md:py-1 md:rounded-lg md:shadow-sm" x-show="kategori==='Sedang'">Rp25.000</p>
                        </label>
                        <label class="border rounded-2xl p-5 flex md:flex-col items-center md:items-start md:justify-between gap-4 cursor-pointer transition-all hover:shadow-md" :class="kategori === 'Besar' ? 'border-primary bg-primary/5 ring-2 ring-primary/20 shadow-sm' : 'border-outline hover:bg-surface-variant'">
                            <input type="radio" name="kategori" value="Besar" x-model="kategori" class="hidden">
                            <span class="material-symbols-outlined text-[36px] md:mb-2" :class="kategori === 'Besar' ? 'text-primary' : 'text-on-surface-variant'">delete_sweep</span>
                            <div class="flex-1 md:w-full">
                                <p class="font-bold text-sm md:text-base text-on-surface">Besar</p>
                                <p class="text-xs text-on-surface-variant mt-1">>2 Tempat Sampah</p>
                            </div>
                            <p class="text-sm font-bold text-on-surface md:mt-4 md:text-primary md:bg-white md:px-3 md:py-1 md:rounded-lg md:shadow-sm" x-show="kategori==='Besar'">Rp40.000</p>
                        </label>
                    </div>
                </div>

                <div class="pt-4 md:hidden">
                    <button @click="step = 2; hargaBase = kategori === 'Kecil' ? 15000 : (kategori === 'Sedang' ? 25000 : 40000)" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 active:scale-95 transition-transform">
                        Lanjut Pilih Jadwal
                    </button>
                </div>
            </div>

            <!-- Step 2: Jadwal -->
            <div x-show="step === 2" 
                 x-transition:enter="transition transform ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="p-4 md:p-0 space-y-6" style="display: none;">
                <div>
                    <div class="flex items-center justify-between mb-4 md:mb-6">
                        <h3 class="font-bold text-on-surface md:text-lg">Pilih Jadwal (Minggu Ini)</h3>
                        <span class="text-xs md:text-sm font-bold text-primary bg-primary/10 px-3 py-1.5 rounded-lg border border-primary/20">Periode: 11 - 17 Mei</span>
                    </div>
                    
                    <div class="grid grid-cols-4 md:grid-cols-4 gap-3 md:gap-4">
                        <label class="border rounded-2xl p-4 md:py-6 flex flex-col items-center gap-1 md:gap-2 cursor-pointer transition-all hover:-translate-y-1 hover:shadow-md" :class="jadwal === 'Senin' ? 'border-primary bg-primary text-white shadow-lg shadow-primary/30 ring-2 ring-primary/20' : 'border-outline bg-white hover:border-primary/50 text-on-surface'">
                            <input type="radio" name="jadwal" value="Senin" x-model="jadwal" class="hidden">
                            <span class="text-xs md:text-sm font-bold opacity-80 uppercase tracking-widest">Sen</span>
                            <span class="text-2xl md:text-3xl font-black">11</span>
                        </label>
                        <label class="border rounded-2xl p-4 md:py-6 flex flex-col items-center gap-1 md:gap-2 cursor-pointer transition-all hover:-translate-y-1 hover:shadow-md" :class="jadwal === 'Selasa' ? 'border-primary bg-primary text-white shadow-lg shadow-primary/30 ring-2 ring-primary/20' : 'border-outline bg-white hover:border-primary/50 text-on-surface'">
                            <input type="radio" name="jadwal" value="Selasa" x-model="jadwal" class="hidden">
                            <span class="text-xs md:text-sm font-bold opacity-80 uppercase tracking-widest">Sel</span>
                            <span class="text-2xl md:text-3xl font-black">12</span>
                        </label>
                        <label class="border rounded-2xl p-4 md:py-6 flex flex-col items-center gap-1 md:gap-2 cursor-pointer transition-all hover:-translate-y-1 hover:shadow-md" :class="jadwal === 'Kamis' ? 'border-primary bg-primary text-white shadow-lg shadow-primary/30 ring-2 ring-primary/20' : 'border-outline bg-white hover:border-primary/50 text-on-surface'">
                            <input type="radio" name="jadwal" value="Kamis" x-model="jadwal" class="hidden">
                            <span class="text-xs md:text-sm font-bold opacity-80 uppercase tracking-widest">Kam</span>
                            <span class="text-2xl md:text-3xl font-black">14</span>
                        </label>
                        <label class="border rounded-2xl p-4 md:py-6 flex flex-col items-center gap-1 md:gap-2 cursor-pointer transition-all hover:-translate-y-1 hover:shadow-md" :class="jadwal === 'Jumat' ? 'border-primary bg-primary text-white shadow-lg shadow-primary/30 ring-2 ring-primary/20' : 'border-outline bg-white hover:border-primary/50 text-on-surface'">
                            <input type="radio" name="jadwal" value="Jumat" x-model="jadwal" class="hidden">
                            <span class="text-xs md:text-sm font-bold opacity-80 uppercase tracking-widest">Jum</span>
                            <span class="text-2xl md:text-3xl font-black">15</span>
                        </label>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="font-bold text-on-surface mb-3 md:text-lg">Catatan (Opsional)</h3>
                    <textarea class="w-full border border-outline rounded-2xl p-4 text-sm md:text-base focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-surface hover:bg-white" rows="3" placeholder="Misal: Tolong ketuk pagar 3 kali, anjing galak..."></textarea>
                </div>

                <div class="flex gap-4 pt-4 md:hidden">
                    <button @click="step = 1" class="w-1/3 bg-white border border-outline text-on-surface font-bold py-4 rounded-xl hover:bg-surface-variant transition-colors">
                        Kembali
                    </button>
                    <button @click="step = 3" :disabled="!jadwal" :class="jadwal ? 'bg-primary shadow-lg shadow-primary/30' : 'bg-surface-variant text-on-surface-variant cursor-not-allowed'" class="w-2/3 text-white font-bold py-4 rounded-xl transition-all">
                        Lanjut Checkout
                    </button>
                </div>
            </div>

            <!-- Step 3: Checkout (Mobile Only) -->
            <div x-show="step === 3" 
                 x-transition:enter="transition transform ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-4"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="p-4 space-y-6 md:hidden" style="display: none;">
                <!-- Content handled by Desktop sidebar logically, but for mobile it's rendered here inline -->
            </div>

            <!-- Step 4: Pembayaran QRIS -->
            <div x-show="step === 4"
                 x-transition:enter="transition transform ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="p-6 md:p-8 space-y-6 text-center max-w-sm mx-auto" style="display: none;">
                
                <h3 class="font-black text-xl text-on-surface">Pembayaran</h3>
                <p class="text-sm text-on-surface-variant">Scan QR Code di bawah ini menggunakan aplikasi M-Banking atau e-Wallet Anda.</p>
                
                <div class="bg-white p-4 rounded-3xl border border-outline shadow-sm inline-block mx-auto relative overflow-hidden">
                    <img src="{{ asset('images/mock_qr.png') }}" alt="QRIS Mockup" class="w-48 h-48 md:w-56 md:h-56 object-cover rounded-xl" :class="isPaying ? 'opacity-50 blur-sm' : ''" onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=EcoTrashPayment';">
                    
                    <div x-show="isPaying" class="absolute inset-0 flex flex-col items-center justify-center">
                        <div class="w-10 h-10 border-4 border-primary border-t-transparent rounded-full animate-spin mb-2"></div>
                        <span class="text-sm font-bold text-primary">Memverifikasi...</span>
                    </div>
                </div>

                <div class="bg-surface-variant p-4 rounded-2xl flex justify-between items-center text-left">
                    <div>
                        <p class="text-xs font-bold text-on-surface-variant mb-1">Total Tagihan</p>
                        <p class="text-lg font-black text-primary" x-text="'Rp' + totalHarga.toLocaleString('id-ID')"></p>
                    </div>
                    <span class="text-xs font-bold bg-white px-2 py-1 rounded shadow-sm">EcoTrash Pay</span>
                </div>

                <button @click="processPayment()" :disabled="isPaying" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span x-show="!isPaying" class="material-symbols-outlined">qr_code_scanner</span>
                    <span x-text="isPaying ? 'Memproses...' : 'Cek Status Pembayaran'"></span>
                </button>
                <button @click="step = 3" x-show="!isPaying" class="w-full text-sm font-bold text-on-surface-variant py-2 hover:text-on-surface transition-colors">Batal & Kembali</button>
            </div>
        </div>

        <!-- Sticky Checkout Sidebar (Desktop) / Mobile Step 3 details -->
        <div class="md:col-span-4" :class="{'hidden md:block': step !== 3, 'hidden': step === 4}">
            <div class="bg-white border border-outline rounded-3xl overflow-hidden shadow-sm md:sticky md:top-28">
                <div class="bg-primary/5 p-5 md:p-6 border-b border-outline">
                    <span class="font-bold text-base md:text-lg text-on-surface block mb-2">Rincian Pesanan</span>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded-md border border-primary/20" x-text="kategori"></span>
                        <span x-show="jadwal" class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-md border border-blue-200" x-text="jadwal"></span>
                    </div>
                </div>
                
                <div class="p-5 md:p-6 space-y-4">
                    <div class="flex justify-between text-sm md:text-base">
                        <span class="text-on-surface-variant">Biaya Layanan</span>
                        <span class="font-bold text-on-surface" x-text="'Rp' + hargaBase.toLocaleString('id-ID')"></span>
                    </div>
                    
                    <!-- Koin Widget -->
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 md:p-5 mt-4 transition-all" :class="saldo > 0 ? 'hover:shadow-md' : 'opacity-70 grayscale'">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2" :class="saldo > 0 ? 'text-amber-600' : 'text-on-surface-variant'">
                                <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">generating_tokens</span>
                                <span class="text-sm font-bold">Pakai Koin Eco</span>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-md" :class="saldo > 0 ? 'text-amber-800 bg-amber-200' : 'text-on-surface bg-outline'">Saldo: <span x-text="saldo"></span></span>
                        </div>
                        
                        <template x-if="saldo > 0">
                            <div>
                                <p class="text-xs text-amber-700/80 mb-3 font-medium">Anda bisa memotong harga hingga <span x-text="'Rp' + (Math.floor(hargaBase * 0.5)).toLocaleString('id-ID')"></span></p>
                                
                                <div class="flex gap-3 items-center bg-white p-2 rounded-xl border border-amber-100 shadow-sm">
                                    <input type="range" min="0" :max="Math.min(saldo, Math.floor(hargaBase * 0.5 / 100))" x-model="koin" class="flex-1 h-2 bg-amber-200 rounded-lg appearance-none cursor-pointer accent-amber-500">
                                    <span class="text-sm font-black text-amber-600 w-12 text-center" x-text="koin"></span>
                                </div>
                                <div class="flex justify-between text-sm mt-3 text-amber-600 font-bold bg-amber-100/50 p-2 rounded-lg" x-show="koin > 0">
                                    <span>Potongan:</span>
                                    <span>-Rp<span x-text="(koin * 100).toLocaleString('id-ID')"></span></span>
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="saldo === 0">
                            <div class="bg-white/50 p-3 rounded-xl border border-amber-200/50 text-center">
                                <p class="text-xs font-bold text-on-surface-variant">Koin tidak mencukupi.</p>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-between items-end pt-4 mt-4 border-t border-dashed border-outline">
                        <span class="font-bold text-base md:text-lg text-on-surface">Total Bayar</span>
                        <span class="font-black text-3xl md:text-4xl text-primary tracking-tight" x-text="'Rp' + totalHarga.toLocaleString('id-ID')"></span>
                    </div>

                    <!-- Desktop Actions -->
                    <div class="hidden md:flex gap-3 pt-6">
                        <button x-show="step === 2" @click="step = 1" class="w-1/3 bg-white border border-outline text-on-surface font-bold py-4 rounded-xl hover:bg-surface-variant transition-colors">Kembali</button>
                        <button x-show="step === 1" @click="step = 2; hargaBase = kategori === 'Kecil' ? 15000 : (kategori === 'Sedang' ? 25000 : 40000)" class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-primary-dark transition-all shadow-lg shadow-primary/30">Pilih Jadwal</button>
                        
                        <button x-show="step === 2" @click="step = 3" :disabled="!jadwal" :class="jadwal ? 'bg-primary hover:bg-primary-dark shadow-lg shadow-primary/30' : 'bg-surface-variant text-on-surface-variant cursor-not-allowed'" class="w-2/3 text-white font-bold py-4 rounded-xl transition-all">Lanjut Checkout</button>
                        
                        <button x-show="step === 3" @click="step = 4" class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-primary-dark transition-all shadow-xl shadow-primary/40 active:scale-95 flex justify-center items-center gap-2 text-lg">
                            <span class="material-symbols-outlined">shopping_cart_checkout</span> Konfirmasi & Bayar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Action (Step 3) -->
            <div class="flex gap-4 p-4 md:hidden" x-show="step === 3">
                <button @click="step = 2" class="w-1/3 bg-white border border-outline text-on-surface font-bold py-4 rounded-xl hover:bg-surface-variant transition-colors">
                    Kembali
                </button>
                <button @click="step = 4" class="w-2/3 bg-primary text-white font-bold py-4 rounded-xl shadow-xl shadow-primary/30 active:scale-95 transition-transform">
                    Konfirmasi & Bayar
                </button>
            </div>
        </div>

    </div>

    <!-- Address Modal Edge Case -->
    <div x-show="showAddressModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showAddressModal = false">
        <div x-show="showAddressModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative">
            <div class="p-5 border-b border-outline flex justify-between items-center">
                <h3 class="font-bold text-lg text-on-surface">Pilih Alamat</h3>
                <button @click="showAddressModal = false" class="text-on-surface-variant hover:text-red-500"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="p-5 space-y-3">
                <template x-for="addr in addresses" :key="addr.id">
                    <div class="border rounded-2xl p-4 transition-colors group relative" :class="selectedAddressId === addr.id ? 'border-primary bg-primary/5' : 'border-outline hover:border-primary/50'">
                        <div class="flex justify-between items-start mb-1">
                            <div @click="selectedAddressId = addr.id; showAddressModal = false" class="flex-1 cursor-pointer">
                                <p class="font-bold text-sm" :class="selectedAddressId === addr.id ? 'text-primary' : 'text-on-surface'" x-text="addr.title + ' (Komplek ' + addr.komplek + ')'"></p>
                                <p class="text-xs text-on-surface-variant mt-1" x-text="addr.detail"></p>
                            </div>
                            <button @click.stop="startEdit(addr)" class="p-2 -mr-2 rounded-full hover:bg-primary/10 text-primary transition-colors">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                        </div>
                    </div>
                </template>
                <button @click="showAddAddressForm = true" class="w-full border-2 border-dashed border-outline rounded-2xl p-4 mt-2 flex items-center justify-center gap-2 text-on-surface-variant hover:bg-surface-dim hover:text-primary hover:border-primary/50 transition-all font-bold text-sm">
                    <span class="material-symbols-outlined text-[20px]">add</span> Tambah Alamat Baru
                </button>
            </div>
        </div>
    </div>
    
    <!-- Add Address Form Modal -->
    <div x-show="showAddAddressForm" x-transition.opacity class="fixed inset-0 bg-black/50 z-[110] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showAddAddressForm = false">
        <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative p-5 space-y-4"
             x-show="showAddAddressForm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-data="{ newAddr: { title: '', komplek: '', detail: '' } }">
            <h3 class="font-bold text-lg text-on-surface mb-2">Tambah Alamat Baru</h3>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Nama Alamat (Misal: Rumah, Kantor)</label>
                <input type="text" x-model="newAddr.title" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white" placeholder="Cth: Rumah Nenek">
            </div>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Pilih Perumahan/Komplek</label>
                <div class="relative">
                    <select x-model="newAddr.komplek" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white appearance-none cursor-pointer">
                        <option value="" disabled selected>Pilih salah satu...</option>
                        <option value="Bunga Asri">Komplek Bunga Asri</option>
                        <option value="Griya Indah">Perumahan Griya Indah</option>
                        <option value="Pesona Alam">Pesona Alam Residence</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Detail Alamat</label>
                <textarea rows="3" x-model="newAddr.detail" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Nama Jalan, RT/RW, Kelurahan"></textarea>
            </div>
            <div class="flex gap-3 mt-4">
                <button @click="showAddAddressForm = false" class="flex-1 py-3 text-sm font-bold text-on-surface-variant bg-surface-variant rounded-xl">Batal</button>
                <button @click="addresses.push({id: Date.now(), ...newAddr}); showAddAddressForm = false; showToast('Alamat baru ditambahkan', 'success');" class="flex-1 py-3 text-sm font-bold text-white bg-primary hover:bg-primary-dark rounded-xl shadow-md">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Edit Address Form Modal -->
    <div x-show="showEditAddressForm" x-transition.opacity class="fixed inset-0 bg-black/50 z-[110] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showEditAddressForm = false">
        <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative p-5 space-y-4"
             x-show="showEditAddressForm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <h3 class="font-bold text-lg text-on-surface mb-2">Ubah Alamat</h3>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Nama Alamat (Misal: Rumah, Kantor)</label>
                <input type="text" x-model="editingAddress.title" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
            </div>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Pilih Perumahan/Komplek</label>
                <div class="relative">
                    <select x-model="editingAddress.komplek" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white appearance-none cursor-pointer">
                        <option value="Bunga Asri">Komplek Bunga Asri</option>
                        <option value="Griya Indah">Perumahan Griya Indah</option>
                        <option value="Pesona Alam">Pesona Alam Residence</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                </div>
            </div>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Detail Alamat</label>
                <textarea rows="3" x-model="editingAddress.detail" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Nama Jalan, RT/RW, Kelurahan"></textarea>
            </div>
            <div class="flex gap-3 mt-4">
                <button @click="showEditAddressForm = false" class="flex-1 py-3 text-sm font-bold text-on-surface-variant bg-surface-variant rounded-xl">Batal</button>
                <button @click="saveEdit()" class="flex-1 py-3 text-sm font-bold text-white bg-primary hover:bg-primary-dark rounded-xl shadow-md">Simpan Perubahan</button>
            </div>
        </div>
    </div>


</div>
@endsection
