@extends('layouts.app')

@section('title', 'Daftar Pengajuan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pengajuan Saya</h1>
            <p class="mt-2 text-gray-600">Daftar semua pengajuan yang telah Anda buat</p>
        </div>
        <div>
            <a href="{{ route('pengajuan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Buat Pengajuan Baru
            </a>
        </div>
    </div>

    <!-- Pengajuan List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        @if($pengajuan->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($pengajuan as $item)
            <li>
                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($item->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($item->status == 'approved') bg-green-100 text-green-800
                                    @elseif($item->status == 'rejected') bg-red-100 text-red-800
                                    @elseif($item->status == 'revision') bg-blue-100 text-blue-800
                                    @elseif($item->status == 'draft') bg-gray-100 text-gray-800
                                    @endif">
                                    @if($item->status == 'pending') Menunggu Persetujuan
                                    @elseif($item->status == 'approved') Disetujui
                                    @elseif($item->status == 'rejected') Ditolak
                                    @elseif($item->status == 'revision') Perlu Revisi
                                    @elseif($item->status == 'draft') Draft
                                    @endif
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->judul }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $item->nomor_pengajuan }} • {{ $item->tanggal_pengajuan->format('d/m/Y H:i') }}
                                </div>
                                @if($item->catatan_approval)
                                <div class="text-sm text-gray-600 mt-1">
                                    <strong>Catatan:</strong> {{ $item->catatan_approval }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                                <div class="text-sm text-gray-500">{{ $item->items->count() }} item</div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('pengajuan.show', $item) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Detail
                                </a>
                                @if($item->status == 'pending' || $item->status == 'revision' || $item->status == 'draft')
                                <a href="{{ route('pengajuan.edit', $item) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded-md text-indigo-700 bg-white hover:bg-gray-50">
                                    Edit
                                </a>
                                @endif
                                @if($item->status == 'pending' || $item->status == 'draft')
                                <form action="{{ route('pengajuan.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-red-300 text-xs font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div class="px-4 py-8 sm:px-6 text-center">
            <div class="text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pengajuan</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat pengajuan keuangan pertama Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('pengajuan.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Buat Pengajuan
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($pengajuan->hasPages())
    <div class="mt-6">
        {{ $pengajuan->links() }}
    </div>
    @endif
</div>
@endsection
