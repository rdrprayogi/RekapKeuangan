@extends('layouts.app')

@section('title', 'Dashboard Approver')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Approver</h1>
        <p class="mt-2 text-gray-600">Selamat datang, {{ auth()->user()->name }}</p>
        <p class="text-sm text-gray-500">{{ auth()->user()->jabatan }} - {{ auth()->user()->unit_kerja }}</p>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <div class="flex space-x-4">
            <a href="{{ route('approval.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Lihat Pengajuan Pending
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('pengajuan.pending') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-200 transform hover:scale-105">
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Approval</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_approval'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pengajuan.revision') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-200 transform hover:scale-105">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Perlu Revisi</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['revision_pending'] }}</dd>
                            <dd class="text-xs text-gray-400">Belum di-resubmit</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </a>

        <a href="{{ route('pengajuan.approved') }}" class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-200 transform hover:scale-105">
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
                            <dt class="text-sm font-medium text-gray-500 truncate">Sudah Saya Setujui</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['approved_by_me'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </a>

        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition duration-200 transform hover:scale-105 cursor-pointer">
            <a href="{{ route('approval.revision_history') }}" class="block p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-600 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Revisi History</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['revision_history_total'] }}</dd>
                            <dd class="text-xs text-gray-400">Klik untuk lihat detail</dd>
                        </dl>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Revenue Summary -->
    <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-600 rounded-md flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Nilai yang Saya Setujui</dt>
                        <dd class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_nilai_approved'], 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
