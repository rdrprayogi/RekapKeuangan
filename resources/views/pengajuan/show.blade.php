@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Pengajuan</h1>
                <p class="mt-2 text-gray-600">Informasi lengkap pengajuan keuangan</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('pengajuan.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                
                @if(in_array($pengajuan->status, ['draft', 'pending']) && (auth()->user()->isPengaju() || auth()->user()->isAdmin()))
                <a href="{{ route('pengajuan.edit', $pengajuan) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <span class="px-4 py-2 rounded-full text-sm font-medium
                @if($pengajuan->status === 'draft') bg-gray-100 text-gray-800
                @elseif($pengajuan->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($pengajuan->status === 'approved') bg-green-100 text-green-800
                @elseif($pengajuan->status === 'rejected') bg-red-100 text-red-800
                @elseif($pengajuan->status === 'revision') bg-blue-100 text-blue-800
                @endif">
                @if($pengajuan->status === 'draft') Draft
                @elseif($pengajuan->status === 'pending') Menunggu Persetujuan
                @elseif($pengajuan->status === 'approved') Disetujui
                @elseif($pengajuan->status === 'rejected') Ditolak
                @elseif($pengajuan->status === 'revision') Perlu Revisi
                @endif
            </span>
            <span class="text-sm text-gray-500">
                ID: #{{ str_pad($pengajuan->id, 6, '0', STR_PAD_LEFT) }}
            </span>
            <span class="text-sm text-gray-500">
                Dibuat: {{ $pengajuan->created_at->format('d M Y, H:i') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="px-6 py-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Pengajuan
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Pengajuan</label>
                            <p class="text-lg text-gray-900 bg-gray-50 rounded-lg p-4 border">{{ $pengajuan->judul }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Pengajuan</label>
                            <div class="text-gray-900 bg-gray-50 rounded-lg p-4 border whitespace-pre-line">{{ $pengajuan->deskripsi }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Keperluan/Tujuan Penggunaan</label>
                            <div class="text-gray-900 bg-gray-50 rounded-lg p-4 border whitespace-pre-line">{{ $pengajuan->keperluan }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Detail -->
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="px-6 py-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        Detail Item ({{ $pengajuan->items->count() }} Item)
                    </h3>
                    
                    <div class="space-y-4">
                        @forelse($pengajuan->items as $index => $item)
                        <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 bg-gray-50">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-lg font-medium text-gray-800 flex items-center">
                                    <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full mr-2">
                                        Item #{{ $index + 1 }}
                                    </span>
                                    {{ $item->nama_barang }}
                                </h4>
                                <span class="text-lg font-bold text-indigo-600">
                                    Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-sm font-semibold text-gray-700">Jumlah:</span>
                                    <p class="text-gray-900">{{ $item->jumlah }} {{ $item->satuan }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-gray-700">Harga Satuan:</span>
                                    <p class="text-gray-900">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-gray-700">Total:</span>
                                    <p class="text-gray-900 font-semibold">Rp {{ number_format($item->jumlah * $item->harga_satuan, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            
                            @if($item->deskripsi_barang)
                            <div class="mt-4">
                                <span class="text-sm font-semibold text-gray-700">Spesifikasi/Keterangan:</span>
                                <p class="text-gray-900 mt-1 whitespace-pre-line">{{ $item->deskripsi_barang }}</p>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="mt-2 text-gray-500">Tidak ada item dalam pengajuan ini</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Grand Total -->
                    <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Total Keseluruhan:</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $pengajuan->items->count() }} item dalam pengajuan ini</p>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-indigo-600">
                                    Rp {{ number_format($pengajuan->items->sum(function($item) { return $item->jumlah * $item->harga_satuan; }), 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Pengaju Info -->
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pengaju
                    </h3>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-semibold text-gray-700">Nama:</span>
                            <p class="text-gray-900">{{ $pengajuan->user->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-700">Email:</span>
                            <p class="text-gray-900">{{ $pengajuan->user->email }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-700">Role:</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($pengajuan->user->userRole?->name ?? 'User') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Timeline
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Pengajuan Dibuat</p>
                                <p class="text-xs text-gray-500">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($pengajuan->status !== 'draft')
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Menunggu Approval</p>
                                <p class="text-xs text-gray-500">{{ $pengajuan->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if(in_array($pengajuan->status, ['approved', 'rejected', 'revision']))
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-3 h-3 
                                    @if($pengajuan->status === 'approved') bg-green-500
                                    @elseif($pengajuan->status === 'rejected') bg-red-500
                                    @elseif($pengajuan->status === 'revision') bg-blue-500
                                    @endif rounded-full"></div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    @if($pengajuan->status === 'approved') Disetujui
                                    @elseif($pengajuan->status === 'rejected') Ditolak
                                    @elseif($pengajuan->status === 'revision') Diminta Revisi
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500">{{ $pengajuan->tanggal_approval ? $pengajuan->tanggal_approval->format('d M Y, H:i') : $pengajuan->updated_at->format('d M Y, H:i') }}</p>
                                @if($pengajuan->catatan_approval)
                                <p class="text-xs text-gray-600 mt-1">{{ $pengajuan->catatan_approval }}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if(in_array($pengajuan->status, ['draft', 'pending', 'revision']) && (auth()->user()->isPengaju() || auth()->user()->isAdmin()))
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('pengajuan.edit', $pengajuan) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Pengajuan
                        </a>
                        
                        <button onclick="confirmDelete()" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus Pengajuan
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@if(in_array($pengajuan->status, ['draft', 'pending', 'revision']) && (auth()->user()->isPengaju() || auth()->user()->isAdmin()))
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">Hapus Pengajuan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus pengajuan ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="deleteForm" action="{{ route('pengajuan.destroy', $pengajuan) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-auto mr-2 shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Ya, Hapus
                    </button>
                </form>
                <button onclick="hideDeleteModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function hideDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endif
@endsection
