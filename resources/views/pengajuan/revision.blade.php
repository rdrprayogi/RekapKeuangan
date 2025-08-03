@extends('layouts.app')

@section('title', 'Pengajuan Perlu Revisi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pengajuan Perlu Revisi</h1>
                <p class="mt-2 text-gray-600">Daftar pengajuan yang perlu direvisi dan diperbaiki</p>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Summary -->
    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-blue-800">Total Pengajuan Perlu Revisi</h3>
                <p class="text-2xl font-bold text-blue-900">{{ $pengajuan->total() }} Pengajuan</p>
                <p class="text-sm text-blue-700">
                    Total nilai: Rp {{ number_format($pengajuan->sum('total_harga'), 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Filter and Sort -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">Urutkan berdasarkan:</span>
                <select onchange="window.location.href=this.value" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="{{ route('pengajuan.revision') }}?sort=newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru Diminta Revisi</option>
                    <option value="{{ route('pengajuan.revision') }}?sort=oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama Diminta Revisi</option>
                    <option value="{{ route('pengajuan.revision') }}?sort=highest" {{ request('sort') === 'highest' ? 'selected' : '' }}>Nilai Tertinggi</option>
                    <option value="{{ route('pengajuan.revision') }}?sort=lowest" {{ request('sort') === 'lowest' ? 'selected' : '' }}>Nilai Terendah</option>
                </select>
            </div>
            <div class="text-sm text-gray-500">
                Menampilkan {{ $pengajuan->firstItem() ?? 0 }} - {{ $pengajuan->lastItem() ?? 0 }} dari {{ $pengajuan->total() }} pengajuan
            </div>
        </div>
    </div>

    <!-- Pengajuan List -->
    <div class="bg-white shadow-lg rounded-lg border border-gray-200">
        @if($pengajuan->count() > 0)
        <div class="divide-y divide-gray-200">
            @foreach($pengajuan as $item)
            <div class="px-6 py-6 hover:bg-gray-50 transition duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <!-- Status Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Pengajuan Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $item->judul }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Perlu Revisi
                                </span>
                            </div>
                            
                            <div class="space-y-1">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $item->nomor_pengajuan }}
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $item->user->name }}
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Diminta revisi: {{ $item->tanggal_revision ? $item->tanggal_revision->format('d M Y, H:i') : '-' }}
                                    @if($item->tanggal_revision)
                                    <span class="ml-2 text-blue-600">
                                        ({{ $item->tanggal_revision->diffForHumans() }})
                                    </span>
                                    @endif
                                </div>
                                
                                @if($item->reviser)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Diminta oleh: {{ $item->reviser->name }}
                                </div>
                                @endif
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    {{ $item->items->count() }} item
                                </div>
                            </div>
                            
                            @if($item->catatan_approval)
                            <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <span class="font-medium">Catatan Revisi:</span> {{ $item->catatan_approval }}
                                </p>
                            </div>
                            @endif
                            
                            <div class="mt-3">
                                <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($item->keperluan, 150) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Amount and Actions -->
                    <div class="flex flex-col items-end space-y-3">
                        <div class="text-right">
                            <div class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500">Perlu Revisi</div>
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('pengajuan.show', $item) }}" 
                               class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Detail
                            </a>
                            
                            @if($item->user_id === auth()->id() || auth()->user()->isAdmin())
                            <a href="{{ route('pengajuan.edit', $item) }}" 
                               class="inline-flex items-center px-3 py-2 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit & Kirim Ulang
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="px-6 py-12 text-center">
            <div class="text-gray-500">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengajuan perlu revisi</h3>
                <p class="text-gray-500">Semua pengajuan sudah sesuai atau belum ada yang diminta revisi.</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($pengajuan->hasPages())
    <div class="mt-6">
        {{ $pengajuan->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
