@extends('layouts.app')

@section('title', 'Tren Mingguan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">📈 Tren Pengeluaran Mingguan</h1>
        <p class="text-gray-600">Analisis tren pengeluaran dalam 8 minggu terakhir</p>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-6 bg-white rounded-lg shadow border border-gray-200">
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('analisis.weekly') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 bg-blue-100 text-blue-700 border border-blue-300">
                    📈 Tren Mingguan
                </a>
                
                <a href="{{ route('analisis.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-gray-700 hover:bg-gray-50 border border-gray-300">
                    📊 Analisis Bulanan
                </a>
                
                <a href="{{ route('analisis.yearly') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-gray-700 hover:bg-gray-50 border border-gray-300">
                    📅 Laporan Tahunan
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Pengeluaran Minggu Ini -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-700 rounded-lg flex items-center justify-center">
                        💰
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Total 8 Minggu</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Rata-rata per Minggu -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-green-700 rounded-lg flex items-center justify-center">
                        📊
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Rata-rata/Minggu</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($rataRata, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Minggu Tertinggi -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-purple-700 rounded-lg flex items-center justify-center">
                        📈
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold">Minggu Tertinggi</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($mingguTertinggi, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Tren Mingguan -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">📈 Tren Pengeluaran 8 Minggu Terakhir</h3>
        <div class="space-y-4">
            @php
                $maxTotal = collect($weeklyData)->max('total');
            @endphp
            @foreach($weeklyData as $data)
            <div class="flex items-center space-x-4">
                <div class="w-24 text-sm font-medium text-gray-700">{{ $data['minggu'] }}</div>
                <div class="flex-1">
                    <div class="bg-gray-200 rounded-full h-6 relative overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-6 rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-2" 
                             style="width: {{ $maxTotal > 0 ? ($data['total'] / $maxTotal) * 100 : 0 }}%">
                            @if($data['total'] > 0)
                                <span class="text-white text-xs font-bold">{{ $data['count'] }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-32 text-right text-sm font-bold text-gray-900">
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
        animation: slideIn 1.5s ease-out forwards;
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
            }, 100);
        });
    });
</script>
@endsection
