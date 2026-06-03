@extends('layouts.warga')

@section('title', 'Profil Saya')

@section('header')
<div class="flex items-center gap-3 w-full justify-center">
    <span class="font-bold text-on-surface text-lg">Profil</span>
</div>
@endsection

@section('content')
{{-- Flash Messages --}}
@if(session('success'))
<div class="mx-4 md:mx-0 mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2">
    <span class="material-symbols-outlined text-[20px]">check_circle</span>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="mx-4 md:mx-0 mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium flex items-center gap-2">
    <span class="material-symbols-outlined text-[20px]">error</span>
    {{ session('error') }}
</div>
@endif
@if($errors->any())
<div class="mx-4 md:mx-0 mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium">
    <div class="flex items-center gap-2 mb-2">
        <span class="material-symbols-outlined text-[20px]">error</span>
        <span class="font-bold">Terdapat kesalahan:</span>
    </div>
    <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="p-4 md:p-0 md:grid md:grid-cols-12 md:gap-8 md:items-start" x-data="{ 
    showAddressModal: false, 
    showEditProfileModal: false, 
    showSecurityModal: false, 
    showAddAddressForm: false, 
    showDeleteAddressConfirm: false,
    showEditAddressForm: false,
    deleteAddressId: null,
    primaryId: {{ $primaryAddressId ?? 'null' }},
    editingAddress: { id: null, title: '', komplek_id: '', blok_nomor_rumah: '', detail_patokan: '' },
    profileImage: null,
    handleImageUpload(e) {
        const file = e.target.files[0];
        if (file) {
            this.profileImage = URL.createObjectURL(file);
        }
    },
    addresses: {{ json_encode($addressesJson) }},
    startEdit(addr) {
        this.editingAddress = {
            id: addr.id,
            title: addr.title,
            komplek_id: addr.komplek_id,
            blok_nomor_rumah: addr.blok_nomor_rumah,
            detail_patokan: addr.detail_patokan
        };
        this.showEditAddressForm = true;
    }
}">
    
    <!-- Left Column: Profile Card (Desktop) / Mobile Header -->
    <div class="md:col-span-4 bg-white md:rounded-3xl md:shadow-sm md:border md:border-primary/20 md:p-8 md:sticky md:top-28">
        <div class="flex flex-col items-center justify-center pt-4 pb-8 md:py-0 relative">
            <div class="absolute top-0 w-full h-24 bg-gradient-to-b from-primary/10 to-transparent -mx-4 px-4 rounded-b-3xl md:hidden"></div>
            
            <div class="w-28 h-28 md:w-36 md:h-36 rounded-full bg-surface flex items-center justify-center text-primary text-5xl md:text-6xl font-black mb-4 border-4 border-white shadow-lg relative z-10 overflow-hidden group">
                <template x-if="!profileImage">
                    <span>{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                </template>
                <template x-if="profileImage">
                    <img :src="profileImage" alt="Profile" class="w-full h-full object-cover">
                </template>
                
                <label for="profile_upload" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white">
                    <span class="material-symbols-outlined text-[32px]">photo_camera</span>
                </label>
                <input type="file" id="profile_upload" accept="image/*" class="hidden" @change="handleImageUpload">
            </div>

            <h2 class="font-black text-2xl md:text-3xl text-on-surface z-10">{{ $user->nama }}</h2>
            <p class="text-sm md:text-base font-medium text-on-surface-variant z-10">{{ $user->email }}</p>
            <div class="mt-4 flex items-center gap-2 bg-amber-50 border border-amber-200 px-4 py-2 rounded-full text-amber-600 font-bold shadow-sm z-10">
                <span class="material-symbols-outlined">generating_tokens</span>
                {{ $user->saldo_koin }} Koin Eco
            </div>
        </div>
    </div>

    <!-- Right Column: Settings List -->
    <div class="md:col-span-8">
        <div class="hidden md:block mb-8">
            <h2 class="text-2xl font-black text-on-surface">Pengaturan Akun</h2>
            <p class="text-on-surface-variant mt-1">Kelola preferensi, alamat penjemputan, dan keamanan akun Anda.</p>
        </div>

        <div class="bg-white border border-primary/20 rounded-3xl overflow-hidden shadow-sm md:shadow-none md:border-none md:bg-transparent md:space-y-4">
            
            <button @click="showEditProfileModal = true" class="w-full text-left flex items-center gap-4 md:gap-6 p-4 md:p-6 border-b border-primary/20 md:border md:border-primary/20 md:rounded-2xl md:bg-white hover:bg-primary/5 md:hover:border-primary transition-colors active:bg-primary/10 group">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[24px]">manage_accounts</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-base md:text-lg text-on-surface">Ubah Informasi Profil</p>
                    <p class="text-xs md:text-sm text-on-surface-variant mt-0.5">Nama, Email, dan Nomor Telepon</p>
                </div>
                <span class="material-symbols-outlined text-on-surface-variant group-hover:translate-x-1 transition-transform">chevron_right</span>
            </button>
            
            <button @click="showAddressModal = true" class="w-full text-left flex items-center gap-4 md:gap-6 p-4 md:p-6 border-b border-primary/20 md:border md:border-primary/20 md:rounded-2xl md:bg-white hover:bg-surface-variant md:hover:border-primary/50 transition-colors active:bg-surface-dim group">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0 group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[24px]">home_pin</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-base md:text-lg text-on-surface">Kelola Alamat</p>
                    <p class="text-xs md:text-sm text-on-surface-variant mt-0.5">{{ $alamatList->count() }} Alamat Tersimpan</p>
                </div>
                <span class="material-symbols-outlined text-on-surface-variant group-hover:translate-x-1 transition-transform">chevron_right</span>
            </button>
            
            <a href="{{ route('warga.edukasi.tersimpan') }}" class="flex items-center gap-4 md:gap-6 p-4 md:p-6 border-b border-primary/20 md:border md:border-primary/20 md:rounded-2xl md:bg-white hover:bg-surface-variant md:hover:border-amber-500/50 transition-colors active:bg-surface-dim group">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 shrink-0 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">bookmarks</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-base md:text-lg text-on-surface">Artikel Edukasi Tersimpan</p>
                    <p class="text-xs md:text-sm text-on-surface-variant mt-0.5">Anda menyimpan {{ auth()->user()->bookmarkArtikel()->count() }} artikel.</p>
                </div>
                <span class="material-symbols-outlined text-on-surface-variant group-hover:translate-x-1 transition-transform">chevron_right</span>
            </a>

            <button @click="showSecurityModal = true" class="w-full text-left flex items-center gap-4 md:gap-6 p-4 md:p-6 border-b border-primary/20 md:border md:border-primary/20 md:rounded-2xl md:bg-white hover:bg-surface-variant md:hover:border-primary/50 transition-colors active:bg-surface-dim group">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-surface-dim flex items-center justify-center text-on-surface-variant shrink-0 group-hover:bg-on-surface group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[24px]">lock</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-base md:text-lg text-on-surface">Keamanan & Password</p>
                    <p class="text-xs md:text-sm text-on-surface-variant mt-0.5">Ubah sandi atau aktifkan 2FA.</p>
                </div>
                <span class="material-symbols-outlined text-on-surface-variant group-hover:translate-x-1 transition-transform">chevron_right</span>
            </button>

            <a href="{{ route('warga.bantuan') }}" class="flex items-center gap-4 md:gap-6 p-4 md:p-6 md:border md:border-primary/20 md:rounded-2xl md:bg-white hover:bg-surface-variant md:hover:border-blue-500/50 transition-colors active:bg-surface-dim group">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 shrink-0 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[24px]">support_agent</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-base md:text-lg text-on-surface">Bantuan & Syarat Ketentuan</p>
                    <p class="text-xs md:text-sm text-on-surface-variant mt-0.5">Hubungi dukungan aplikasi EcoTrash.</p>
                </div>
                <span class="material-symbols-outlined text-on-surface-variant group-hover:translate-x-1 transition-transform">chevron_right</span>
            </a>
        </div>
        
        <p class="text-center md:text-left text-xs font-bold text-on-surface-variant mt-8 uppercase tracking-widest">EcoTrash App v1.0.0</p>
        
        <!-- Mobile Only Logout (Moved to bottom) -->
        <div class="mt-8 mb-4 w-full md:hidden">
            <button @click="showLogoutModal = true" class="w-full bg-white border border-red-200 text-red-600 font-bold py-4 rounded-xl flex items-center justify-center gap-2 hover:bg-red-50 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[20px]">logout</span>
                Keluar dari Akun
            </button>
        </div>
    </div>
    <!-- Address Modal -->
    <div x-show="showAddressModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showAddressModal = false">
        <div x-show="showAddressModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden relative">
            
            <div class="p-6 border-b border-outline flex justify-between items-center">
                <h3 class="font-black text-xl text-on-surface">Kelola Alamat</h3>
                <button @click="showAddressModal = false" class="w-8 h-8 rounded-full bg-surface-variant flex items-center justify-center text-on-surface hover:bg-red-100 hover:text-red-600 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
            
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <template x-for="addr in addresses" :key="addr.id">
                    <div class="border rounded-2xl p-4 flex gap-4 items-start relative overflow-hidden transition-all" :class="primaryId === addr.id ? 'border-primary bg-primary/5' : 'border-outline hover:border-primary/50'">
                        <div x-show="primaryId === addr.id" class="absolute top-0 right-0 bg-primary text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg uppercase tracking-wider">Utama</div>
                        <span class="material-symbols-outlined mt-0.5" :class="primaryId === addr.id ? 'text-primary' : 'text-on-surface-variant'">location_on</span>
                        <div class="w-full">
                            <p class="font-bold text-sm text-on-surface" x-text="addr.title + ' (Komplek ' + addr.komplek + ')'"></p>
                            <p class="text-xs text-on-surface-variant mt-1 mb-3" x-text="addr.detail"></p>
                            <div class="flex gap-2 justify-between w-full">
                                <div class="flex gap-2">
                                    <button @click.stop="startEdit(addr)" class="text-xs font-bold text-primary hover:underline">Edit</button>
                                    <span class="text-outline">|</span>
                                    <button @click="deleteAddressId = addr.id; showDeleteAddressConfirm = true" class="text-xs font-bold text-red-500 hover:underline">Hapus</button>
                                </div>
                                <template x-if="primaryId !== addr.id">
                                    <form :action="'{{ url('warga/profil/alamat') }}/' + addr.id + '/utama'" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded-md border border-primary/20 hover:bg-primary/20 transition-colors">Jadikan Utama</button>
                                    </form>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

                <button @click="showAddAddressForm = true" class="w-full border-2 border-dashed border-outline rounded-2xl p-4 flex flex-col items-center justify-center gap-2 text-on-surface-variant hover:bg-surface-dim hover:text-primary hover:border-primary/50 transition-all group">
                    <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                    </div>
                    <span class="text-sm font-bold">Tambah Alamat Baru</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div x-show="showEditProfileModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showEditProfileModal = false">
        <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative p-6 space-y-4"
             x-show="showEditProfileModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <form action="{{ route('warga.profil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <h3 class="font-bold text-lg text-on-surface mb-2">Edit Profil</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled class="w-full border border-outline rounded-xl p-3 text-sm bg-surface-dim text-on-surface-variant cursor-not-allowed outline-none">
                        <p class="text-[10px] text-on-surface-variant mt-1">Email tidak dapat diubah.</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Nomor HP</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="showEditProfileModal = false" class="flex-1 py-3 text-sm font-bold text-on-surface-variant bg-surface-variant rounded-xl">Batal</button>
                    <button type="submit" class="flex-1 py-3 text-sm font-bold text-white bg-primary hover:bg-primary-dark rounded-xl shadow-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Security Modal -->
    <div x-show="showSecurityModal" x-transition.opacity class="fixed inset-0 bg-black/50 z-[100] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showSecurityModal = false">
        <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative p-6 space-y-4"
             x-show="showSecurityModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <h3 class="font-bold text-lg text-on-surface mb-2">Ubah Kata Sandi</h3>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Kata Sandi Lama</label>
                <input type="password" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Masukkan sandi lama">
            </div>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Kata Sandi Baru</label>
                <input type="password" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Masukkan sandi baru">
            </div>
            <div>
                <label class="text-xs font-bold text-on-surface-variant block mb-1">Ulangi Kata Sandi Baru</label>
                <input type="password" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Ketik ulang sandi baru">
            </div>
            <div class="flex gap-3 mt-6">
                <button @click="showSecurityModal = false" class="flex-1 py-3 text-sm font-bold text-on-surface-variant bg-surface-variant rounded-xl">Batal</button>
                <button @click="showSecurityModal = false" class="flex-1 py-3 text-sm font-bold text-white bg-primary hover:bg-primary-dark rounded-xl shadow-md">Simpan Sandi</button>
            </div>
        </div>
    </div>

    <!-- Add Address Form Modal -->
    <div x-show="showAddAddressForm" x-transition.opacity class="fixed inset-0 bg-black/50 z-[110] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showAddAddressForm = false">
        <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative p-6 space-y-4"
             x-show="showAddAddressForm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <form action="{{ route('warga.profil.alamat.store') }}" method="POST">
                @csrf
                <h3 class="font-bold text-lg text-on-surface mb-2">Tambah Alamat Baru</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Nama Alamat (Misal: Rumah, Kantor)</label>
                        <input type="text" name="nama_alamat" value="{{ old('nama_alamat') }}" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Pilih Perumahan/Komplek</label>
                        <div class="relative">
                            <select name="komplek_id" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih salah satu...</option>
                                @foreach($kompleks as $k)
                                    <option value="{{ $k->id }}" {{ old('komplek_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_komplek }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Alamat Lengkap (Blok/Nomor Rumah)</label>
                        <textarea rows="3" name="blok_nomor_rumah" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Nama Jalan, RT/RW, Kelurahan">{{ old('blok_nomor_rumah') }}</textarea>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Patokan/Detail (Opsional)</label>
                        <input type="text" name="detail_patokan" value="{{ old('detail_patokan') }}" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Cth: Pagar Hitam, Depan Warung">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="showAddAddressForm = false" class="flex-1 py-3 text-sm font-bold text-on-surface-variant bg-surface-variant rounded-xl">Batal</button>
                    <button type="submit" class="flex-1 py-3 text-sm font-bold text-white bg-primary hover:bg-primary-dark rounded-xl shadow-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Edit Address Form Modal -->
    <div x-show="showEditAddressForm" x-transition.opacity class="fixed inset-0 bg-black/50 z-[110] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showEditAddressForm = false">
        <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden relative p-6 space-y-4"
             x-show="showEditAddressForm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0">
            <form :action="'{{ url('warga/profil/alamat') }}/' + editingAddress.id" method="POST">
                @csrf
                @method('PUT')
                <h3 class="font-bold text-lg text-on-surface mb-2">Ubah Alamat</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Nama Alamat (Misal: Rumah, Kantor)</label>
                        <input type="text" name="nama_alamat" x-model="editingAddress.title" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Pilih Perumahan/Komplek</label>
                        <div class="relative">
                            <select name="komplek_id" x-model="editingAddress.komplek_id" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white appearance-none cursor-pointer">
                                @foreach($kompleks as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_komplek }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Alamat Lengkap (Blok/Nomor Rumah)</label>
                        <textarea rows="3" name="blok_nomor_rumah" x-model="editingAddress.blok_nomor_rumah" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Nama Jalan, RT/RW, Kelurahan"></textarea>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-on-surface-variant block mb-1">Patokan/Detail (Opsional)</label>
                        <input type="text" name="detail_patokan" x-model="editingAddress.detail_patokan" class="w-full border border-outline rounded-xl p-3 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" placeholder="Cth: Pagar Hitam, Depan Warung">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="showEditAddressForm = false" class="flex-1 py-3 text-sm font-bold text-on-surface-variant bg-surface-variant rounded-xl">Batal</button>
                    <button type="submit" class="flex-1 py-3 text-sm font-bold text-white bg-primary hover:bg-primary-dark rounded-xl shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Delete Address Confirmation Modal -->
    <div x-show="showDeleteAddressConfirm" x-transition.opacity class="fixed inset-0 bg-black/50 z-[120] backdrop-blur-sm flex items-center justify-center p-4" style="display:none;" @click.self="showDeleteAddressConfirm = false">
        <div x-show="showDeleteAddressConfirm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden text-center p-6 md:p-8 relative">
            <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-[40px]">delete_forever</span>
            </div>
            <h3 class="font-black text-xl text-on-surface mb-2">Hapus Alamat?</h3>
            <p class="text-sm text-on-surface-variant mb-8">Alamat ini akan dihapus secara permanen dari daftar alamat Anda.</p>
            <div class="flex gap-3">
                <button @click="showDeleteAddressConfirm = false" class="flex-1 font-bold text-on-surface-variant py-3 rounded-xl bg-surface border border-outline hover:bg-surface-variant transition-colors">Batal</button>
                <form :action="'{{ url('warga/profil/alamat') }}/' + deleteAddressId" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full font-bold text-white py-3 rounded-xl bg-red-600 hover:bg-red-700 shadow-lg shadow-red-600/30 transition-colors flex items-center justify-center">Hapus</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
