<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalisisController extends Controller
{
    public function index()
    {
        // Ambil data pengeluaran berdasarkan bulan dalam 6 bulan terakhir
        $monthlyData = $this->getMonthlyData();
        
        // Ambil total pengeluaran
        $totalPengeluaran = Pengajuan::where('status', 'approved')->sum('total_harga');
        
        // Ambil jumlah pengajuan berdasarkan status
        $statusData = [
            'approved' => Pengajuan::where('status', 'approved')->count(),
            'pending' => Pengajuan::where('status', 'pending')->count(),
            'rejected' => Pengajuan::where('status', 'rejected')->count(),
            'revision' => Pengajuan::where('status', 'revision')->count(),
        ];
        
        // Ambil top 5 kategori pengeluaran terbesar (berdasarkan keperluan)
        $topKategori = Pengajuan::where('status', 'approved')
            ->select('keperluan', DB::raw('SUM(total_harga) as total'))
            ->groupBy('keperluan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();
        
        return view('analisis.index', compact('monthlyData', 'totalPengeluaran', 'statusData', 'topKategori'));
    }
    
    public function weekly()
    {
        // Data 8 minggu terakhir
        $weeklyData = $this->getWeeklyData();
        
        return view('analisis.weekly', compact('weeklyData'));
    }
    
    public function yearly()
    {
        // Data 3 tahun terakhir
        $yearlyData = $this->getYearlyData();
        
        return view('analisis.yearly', compact('yearlyData'));
    }
    
    private function getMonthlyData()
    {
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();
            
            $total = Pengajuan::where('status', 'approved')
                ->whereBetween('tanggal_pengajuan', [$monthStart, $monthEnd])
                ->sum('total_harga');
            
            $count = Pengajuan::where('status', 'approved')
                ->whereBetween('tanggal_pengajuan', [$monthStart, $monthEnd])
                ->count();
            
            $data[] = [
                'bulan' => $date->format('M Y'),
                'total' => $total,
                'count' => $count
            ];
        }
        
        return $data;
    }
    
    private function getWeeklyData()
    {
        $data = [];
        
        for ($i = 7; $i >= 0; $i--) {
            $date = Carbon::now()->subWeeks($i);
            $weekStart = $date->copy()->startOfWeek();
            $weekEnd = $date->copy()->endOfWeek();
            
            $total = Pengajuan::where('status', 'approved')
                ->whereBetween('tanggal_pengajuan', [$weekStart, $weekEnd])
                ->sum('total_harga');
            
            $count = Pengajuan::where('status', 'approved')
                ->whereBetween('tanggal_pengajuan', [$weekStart, $weekEnd])
                ->count();
            
            $data[] = [
                'minggu' => $weekStart->format('d M') . ' - ' . $weekEnd->format('d M'),
                'total' => $total,
                'count' => $count
            ];
        }
        
        return $data;
    }
    
    private function getYearlyData()
    {
        $data = [];
        
        for ($i = 2; $i >= 0; $i--) {
            $year = Carbon::now()->subYears($i)->year;
            
            $total = Pengajuan::where('status', 'approved')
                ->whereYear('tanggal_pengajuan', $year)
                ->sum('total_harga');
            
            $count = Pengajuan::where('status', 'approved')
                ->whereYear('tanggal_pengajuan', $year)
                ->count();
            
            $data[] = [
                'tahun' => $year,
                'total' => $total,
                'count' => $count
            ];
        }
        
        return $data;
    }
}
