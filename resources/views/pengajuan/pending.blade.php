@extends('layouts.app')

@section('title', 'Pengajuan Menunggu Approval')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pengajuan Menunggu Approval</h1>
                <p class="mt-2 text-gray-600">Daftar semua pengajuan yang menunggu persetujuan</p>
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
    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-yellow-800">Total Pengajuan Pending</h3>
                <p class="text-2xl font-bold text-yellow-900">{{ $pengajuan->total() }} Pengajuan</p>
                <p class="text-sm text-yellow-700">
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
                    <option value="{{ route('pengajuan.pending') }}?sort=newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="{{ route('pengajuan.pending') }}?sort=oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="{{ route('pengajuan.pending') }}?sort=highest" {{ request('sort') === 'highest' ? 'selected' : '' }}>Nilai Tertinggi</option>
                    <option value="{{ route('pengajuan.pending') }}?sort=lowest" {{ request('sort') === 'lowest' ? 'selected' : '' }}>Nilai Terendah</option>
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
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Pengajuan Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $item->judul }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Menunggu Approval
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $item->tanggal_pengajuan->format('d M Y, H:i') }}
                                    <span class="ml-2 text-yellow-600">
                                        ({{ $item->tanggal_pengajuan->diffForHumans() }})
                                    </span>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    {{ $item->items->count() }} item
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($item->keperluan, 150) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Amount and Actions -->
                    <div class="flex flex-col items-end space-y-3">
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500">Total Pengajuan</div>
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
                            
                            @if(auth()->user()->isApprover() || auth()->user()->isAdmin())
                            <button onclick="openQuickApprovalModal({{ $item->id }}, '{{ $item->judul }}')" 
                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Setujui
                            </button>
                            
                            <button onclick="openQuickRejectModal({{ $item->id }}, '{{ $item->judul }}')" 
                               class="inline-flex items-center px-3 py-2 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak
                            </button>
                            
                            <button onclick="openQuickRevisionModal({{ $item->id }}, '{{ $item->judul }}')" 
                               class="inline-flex items-center px-3 py-2 border border-blue-300 text-sm font-medium rounded-lg text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Revisi
                            </button>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengajuan pending</h3>
                <p class="text-gray-500">Semua pengajuan sudah diproses atau belum ada pengajuan baru.</p>
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

<!-- Quick Approval Modal -->
<div id="quick-approval-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Setujui Pengajuan</h3>
            <p class="text-sm text-gray-500 mb-4">Pengajuan: <span id="quick-approval-title"></span></p>
            <form id="quick-approval-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="quick-approval-note" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea id="quick-approval-note" name="catatan_approval" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Tambahkan catatan approval..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeQuickModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md">
                        Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Reject Modal -->
<div id="quick-reject-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pengajuan</h3>
            <p class="text-sm text-gray-500 mb-4">Pengajuan: <span id="quick-reject-title"></span></p>
            <form id="quick-reject-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="quick-reject-note" class="block text-sm font-medium text-gray-700">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea id="quick-reject-note" name="catatan_approval" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeQuickModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Revision Modal -->
<div id="quick-revision-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Minta Revisi Pengajuan</h3>
            <p class="text-sm text-gray-500 mb-4">Pengajuan: <span id="quick-revision-title"></span></p>
            <form id="quick-revision-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="quick-revision-note" class="block text-sm font-medium text-gray-700">Catatan Revisi <span class="text-red-500">*</span></label>
                    <textarea id="quick-revision-note" name="catatan_approval" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Jelaskan apa yang perlu direvisi..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeQuickModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                        Minta Revisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openQuickApprovalModal(id, title) {
    document.getElementById('quick-approval-title').textContent = title;
    document.getElementById('quick-approval-form').action = `/approval/${id}/approve`;
    document.getElementById('quick-approval-modal').classList.remove('hidden');
}

function openQuickRejectModal(id, title) {
    document.getElementById('quick-reject-title').textContent = title;
    document.getElementById('quick-reject-form').action = `/approval/${id}/reject`;
    document.getElementById('quick-reject-modal').classList.remove('hidden');
}

function openQuickRevisionModal(id, title) {
    document.getElementById('quick-revision-title').textContent = title;
    document.getElementById('quick-revision-form').action = `/approval/${id}/revision`;
    document.getElementById('quick-revision-modal').classList.remove('hidden');
}

function closeQuickModal() {
    document.getElementById('quick-approval-modal').classList.add('hidden');
    document.getElementById('quick-reject-modal').classList.add('hidden');
    document.getElementById('quick-revision-modal').classList.add('hidden');
    // Reset forms
    document.getElementById('quick-approval-form').reset();
    document.getElementById('quick-reject-form').reset();
    document.getElementById('quick-revision-form').reset();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const approvalModal = document.getElementById('quick-approval-modal');
    const rejectModal = document.getElementById('quick-reject-modal');
    const revisionModal = document.getElementById('quick-revision-modal');
    
    if (event.target == approvalModal) {
        closeQuickModal();
    }
    if (event.target == rejectModal) {
        closeQuickModal();
    }
    if (event.target == revisionModal) {
        closeQuickModal();
    }
}
</script>
@endsection
