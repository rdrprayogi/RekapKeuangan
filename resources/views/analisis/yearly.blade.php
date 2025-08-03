@extends('layouts.app')

@section('title', 'Laporan Tahunan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">📅 Laporan Pengeluaran Tahunan</h1>
        <p class="text-gray-600">Laporan komprehensif pengeluaran dalam 3 tahun terakhir</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 bg-white rounded-lg shadow border border-gray-200">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('analisis.weekly') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-gray-700 hover:bg-gray-50 border border-gray-300">
                    📈 Tren Mingguan
                </a>
                
                <a href="{{ route('analisis.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-gray-700 hover:bg-gray-50 border border-gray-300">
                    📊 Analisis Bulanan
                </a>
                
                <a href="{{ route('analisis.yearly') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 bg-purple-100 text-purple-700 border border-purple-300">
                    📅 Laporan Tahunan
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Pengeluaran 3 Tahun -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-purple-700 rounded-lg flex items-center justify-center">
                        💰
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total 3 Tahun</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Rata-rata per Tahun -->
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-indigo-700 rounded-lg flex items-center justify-center">
                        📊
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Rata-rata/Tahun</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($rataRata, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Tahun Tertinggi -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-pink-700 rounded-lg flex items-center justify-center">
                        📈
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Tahun Tertinggi</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($tahunTertinggi, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Laporan Tahunan -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">📅 Laporan Pengeluaran 3 Tahun Terakhir</h3>
        <div class="space-y-6">
            @php
                $maxTotal = collect($yearlyData)->max('total');
            @endphp
            @foreach($yearlyData as $data)
            <div class="flex items-center space-x-4">
                <div class="w-20 text-lg font-bold text-gray-700">{{ $data['tahun'] }}</div>
                <div class="flex-1">
                    <div class="bg-gray-200 rounded-full h-8 relative overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-8 rounded-full transition-all duration-1500 ease-out flex items-center justify-end pr-3" 
                             style="width: {{ $maxTotal > 0 ? ($data['total'] / $maxTotal) * 100 : 0 }}%">
                            @if($data['total'] > 0)
                                <span class="text-white text-sm font-bold">{{ $data['count'] }} pengajuan</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-40 text-right text-sm font-bold text-gray-900">
                    Rp {{ number_format($data['total'], 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    /* Animasi untuk loading bars */
    @keyframes slideIn {
        from {
            width: 0%;
        }
        to {
            width: var(--final-width);
        }
    }
    
    .animate-bar {
        animation: slideIn 2s ease-out forwards;
    }
</style>

<script>
    // Animate bars on page load
    document.addEventListener('DOMContentLoaded', function() {
        const bars = document.querySelectorAll('[style*="width:"]');
        bars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 200);
        });
    });
</script>
@endsection
