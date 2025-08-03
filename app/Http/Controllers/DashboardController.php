<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\RevisionHistory;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isPengaju()) {
            return $this->pengajuDashboard();
        } elseif ($user->isApprover()) {
            return $this->approverDashboard();
        }

        // Fallback jika role tidak dikenali
        return view('dashboard.index', ['user' => $user]);
    }

    private function adminDashboard()
    {
        $stats = [
            'total_pengajuan' => Pengajuan::count(),
            'pending_pengajuan' => Pengajuan::where('status', 'pending')->count(),
            'approved_pengajuan' => Pengajuan::where('status', 'approved')->count(),
            'rejected_pengajuan' => Pengajuan::where('status', 'rejected')->count(),
            'revision_pengajuan' => Pengajuan::where('status', 'revision')->count(),
            'total_nilai' => Pengajuan::where('status', 'approved')->sum('total_harga')
        ];

        $recent_pengajuan = Pengajuan::with(['user', 'approver'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.admin', compact('stats', 'recent_pengajuan'));
    }

    private function pengajuDashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'total_pengajuan' => $user->pengajuan()->count(),
            'pending_pengajuan' => $user->pengajuan()->where('status', 'pending')->count(),
            'approved_pengajuan' => $user->pengajuan()->where('status', 'approved')->count(),
            'rejected_pengajuan' => $user->pengajuan()->where('status', 'rejected')->count(),
            'revision_pengajuan' => $user->pengajuan()->where('status', 'revision')->count(),
        ];

        $recent_pengajuan = $user->pengajuan()
            ->with(['approver'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.pengaju', compact('stats', 'recent_pengajuan'));
    }

    private function approverDashboard()
    {
        $stats = [
            'pending_approval' => Pengajuan::where('status', 'pending')->count(),
            'approved_by_me' => Pengajuan::where('approved_by', Auth::id())->where('status', 'approved')->count(),
            'revision_pending' => Pengajuan::where('revision_by', Auth::id())->where('status', 'revision')->count(),
            'revision_history_total' => \DB::table('revision_history')->where('revision_by', Auth::id())->count(),
            'total_nilai_approved' => Pengajuan::where('approved_by', Auth::id())
                ->where('status', 'approved')
                ->sum('total_harga')
        ];

        $pending_pengajuan = Pengajuan::with(['user', 'items'])
            ->where('status', 'pending')
            ->orderBy('tanggal_pengajuan', 'asc')
            ->take(10)
            ->get();

        return view('dashboard.approver', compact('stats', 'pending_pengajuan'));
    }
}
