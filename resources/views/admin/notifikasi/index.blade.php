@extends('layouts.admin')

@section('title', 'Semua Notifikasi')
@section('subtitle', 'Pantau aktivitas terbaru dan pemberitahuan sistem.')

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium flex items-center gap-2">
    <span class="material-symbols-outlined text-[20px]">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div x-data="{ activeTab: '{{ $tab }}' }">
    <div class="bg-white rounded-xl border border-outline shadow-sm overflow-hidden flex flex-col">
        <!-- Header & Tabs -->
        <div class="p-4 border-b border-outline flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex p-1 bg-surface-dim rounded-lg w-fit">
                <a href="{{ route('admin.notifikasi.index', ['tab' => 'semua']) }}" :class="activeTab === 'semua' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant'" class="px-4 py-1.5 rounded-md text-sm transition-all">Semua</a>
                <a href="{{ route('admin.notifikasi.index', ['tab' => 'unread']) }}" :class="activeTab === 'unread' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant'" class="px-4 py-1.5 rounded-md text-sm transition-all flex items-center gap-2">
                    Belum Dibaca
                    @if($unreadCount > 0)
                    <span class="inline-flex items-center justify-center w-5 h-5 bg-red-500 text-white text-[10px] rounded-full">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.notifikasi.index', ['tab' => 'penting']) }}" :class="activeTab === 'penting' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant'" class="px-4 py-1.5 rounded-md text-sm transition-all">Penting</a>
            </div>
            
            @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifikasi.markAllRead') }}">
                @csrf
                <button type="submit" class="text-sm text-primary font-bold hover:bg-primary/5 px-3 py-2 rounded-lg transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">done_all</span> Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>

        <!-- Notification List -->
        <div class="divide-y divide-outline">
            @forelse($notifikasis as $notif)
            <div class="p-4 flex items-start gap-4 hover:bg-surface-dim transition-colors {{ $notif->is_read ? '' : 'bg-primary/5' }} group">
                @php
                    $icon = 'info';
                    $iconBg = 'bg-primary/10';
                    $iconColor = 'text-primary';
                    
                    if ($notif->tipe === 'success') {
                        $icon = 'check_circle';
                        $iconBg = 'bg-green-50';
                        $iconColor = 'text-green-600';
                    } elseif ($notif->tipe === 'warning') {
                        $icon = 'report';
                        $iconBg = 'bg-yellow-50';
                        $iconColor = 'text-yellow-600';
                    } elseif ($notif->tipe === 'error') {
                        $icon = 'warning';
                        $iconBg = 'bg-red-50';
                        $iconColor = 'text-red-600';
                    }
                @endphp
                <div class="w-10 h-10 rounded-full {{ $iconBg }} flex items-center justify-center {{ $iconColor }} shrink-0">
                    <span class="material-symbols-outlined text-[20px]">{{ $icon }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <h4 class="text-sm font-bold text-on-surface">{{ $notif->judul }}</h4>
                        <span class="text-xs text-on-surface-variant whitespace-nowrap">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-on-surface-variant mt-1">{{ $notif->pesan }}</p>
                </div>
                @if(!$notif->is_read)
                <div class="w-2 h-2 bg-primary rounded-full mt-1.5 shrink-0"></div>
                @endif
            </div>
            @empty
            <div class="py-20 flex flex-col items-center text-center px-4">
                <div class="w-20 h-20 rounded-full bg-surface-dim flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[40px] text-on-surface-variant opacity-30">notifications_off</span>
                </div>
                <h4 class="font-bold text-on-surface">Tidak Ada Notifikasi</h4>
                <p class="text-sm text-on-surface-variant mt-1">
                    @if($tab === 'unread')
                        Semua pemberitahuan Anda sudah dibaca.
                    @elseif($tab === 'penting')
                        Tidak ada pemberitahuan mendesak.
                    @else
                        Belum ada notifikasi yang masuk.
                    @endif
                </p>
            </div>
            @endforelse
        </div>

        <!-- Footer / Pagination -->
        <div class="p-4 border-t border-outline flex flex-col sm:flex-row items-center justify-between gap-4 bg-surface-dim/30">
            <p class="text-xs text-on-surface-variant">
                Menampilkan {{ $notifikasis->firstItem() ?? 0 }} - {{ $notifikasis->lastItem() ?? 0 }} dari {{ $notifikasis->total() }} notifikasi
            </p>
            <div class="flex gap-2">
                {{ $notifikasis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
