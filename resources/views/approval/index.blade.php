@extends('layouts.app')

@section('title', 'Manajemen Approval')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Approval</h1>
        <p class="mt-2 text-gray-600">Kelola persetujuan pengajuan keuangan</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $pengajuan->where('status', 'pending')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Approved</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $pengajuan->where('status', 'approved')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rejected</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $pengajuan->where('status', 'rejected')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Revision</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $pengajuan->where('status', 'revision')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Revision</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $pengajuan->where('status', 'revision')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('approval.index') }}?filter=pending" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request('filter') === 'pending' || !request('filter') ? 'border-indigo-500 text-indigo-600' : '' }}">
                    Pending ({{ $pengajuan->where('status', 'pending')->count() }})
                </a>
                <a href="{{ route('approval.index') }}?filter=approved" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request('filter') === 'approved' ? 'border-indigo-500 text-indigo-600' : '' }}">
                    Approved ({{ $pengajuan->where('status', 'approved')->count() }})
                </a>
                <a href="{{ route('approval.index') }}?filter=rejected" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request('filter') === 'rejected' ? 'border-indigo-500 text-indigo-600' : '' }}">
                    Rejected ({{ $pengajuan->where('status', 'rejected')->count() }})
                </a>
                <a href="{{ route('approval.index') }}?filter=revision" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request('filter') === 'revision' ? 'border-indigo-500 text-indigo-600' : '' }}">
                    Revision ({{ $pengajuan->where('status', 'revision')->count() }})
                </a>
                <a href="{{ route('approval.index') }}?filter=all" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm {{ request('filter') === 'all' ? 'border-indigo-500 text-indigo-600' : '' }}">
                    Semua ({{ $pengajuan->count() }})
                </a>
            </nav>
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
                                    @endif">
                                    @if($item->status == 'pending') Menunggu
                                    @elseif($item->status == 'approved') Disetujui
                                    @elseif($item->status == 'rejected') Ditolak
                                    @elseif($item->status == 'revision') Revisi
                                    @endif
                                </span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->judul }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $item->nomor_pengajuan }} • {{ $item->user->name }} • {{ $item->tanggal_pengajuan->format('d/m/Y H:i') }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $item->items->count() }} item • {{ Str::limit($item->keperluan, 50) }}
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
                                @if($item->approver)
                                <div class="text-xs text-gray-500">oleh {{ $item->approver->name }}</div>
                                @endif
                                <div class="text-xs text-gray-500">{{ $item->tanggal_pengajuan->diffForHumans() }}</div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('pengajuan.show', $item) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Detail
                                </a>
                                @if($item->status == 'pending')
                                <button onclick="openApprovalModal({{ $item->id }}, '{{ $item->judul }}')" class="inline-flex items-center px-3 py-1 border border-green-300 text-xs font-medium rounded-md text-green-700 bg-white hover:bg-green-50">
                                    Approve
                                </button>
                                <button onclick="openRejectModal({{ $item->id }}, '{{ $item->judul }}')" class="inline-flex items-center px-3 py-1 border border-red-300 text-xs font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                    Reject
                                </button>
                                <button onclick="openRevisionModal({{ $item->id }}, '{{ $item->judul }}')" class="inline-flex items-center px-3 py-1 border border-blue-300 text-xs font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                                    Revisi
                                </button>
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
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengajuan</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada pengajuan yang perlu diproses.</p>
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

<!-- Approval Modal -->
<div id="approval-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Setujui Pengajuan</h3>
            <p class="text-sm text-gray-500 mb-4">Pengajuan: <span id="approval-title"></span></p>
            <form id="approval-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="approval-note" class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                    <textarea id="approval-note" name="catatan_approval" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Tambahkan catatan approval..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
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

<!-- Reject Modal -->
<div id="reject-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pengajuan</h3>
            <p class="text-sm text-gray-500 mb-4">Pengajuan: <span id="reject-title"></span></p>
            <form id="reject-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reject-note" class="block text-sm font-medium text-gray-700">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea id="reject-note" name="catatan_approval" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
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

<!-- Revision Modal -->
<div id="revision-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Minta Revisi</h3>
            <p class="text-sm text-gray-500 mb-4">Pengajuan: <span id="revision-title"></span></p>
            <form id="revision-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="revision-note" class="block text-sm font-medium text-gray-700">Catatan Revisi <span class="text-red-500">*</span></label>
                    <textarea id="revision-note" name="catatan" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Jelaskan apa yang perlu direvisi..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
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
function openApprovalModal(id, title) {
    document.getElementById('approval-title').textContent = title;
    document.getElementById('approval-form').action = `/approval/${id}/approve`;
    document.getElementById('approval-modal').classList.remove('hidden');
}

function openRejectModal(id, title) {
    document.getElementById('reject-title').textContent = title;
    document.getElementById('reject-form').action = `/approval/${id}/reject`;
    document.getElementById('reject-modal').classList.remove('hidden');
}

function openRevisionModal(id, title) {
    document.getElementById('revision-title').textContent = title;
    document.getElementById('revision-form').action = `/approval/${id}/revision`;
    document.getElementById('revision-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('approval-modal').classList.add('hidden');
    document.getElementById('reject-modal').classList.add('hidden');
    document.getElementById('revision-modal').classList.add('hidden');
    // Reset forms
    document.getElementById('approval-form').reset();
    document.getElementById('reject-form').reset();
    document.getElementById('revision-form').reset();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const approvalModal = document.getElementById('approval-modal');
    const rejectModal = document.getElementById('reject-modal');
    const revisionModal = document.getElementById('revision-modal');
    if (event.target == approvalModal || event.target == rejectModal || event.target == revisionModal) {
        closeModal();
    }
}
</script>
@endsection
