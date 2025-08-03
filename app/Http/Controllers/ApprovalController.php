<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\RevisionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        // Only approvers and admins can access
        if (!Auth::user()->isApprover() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $filter = $request->get('filter', 'pending');
        
        $query = Pengajuan::with(['user', 'items', 'approver']);

        if ($filter === 'pending') {
            $query->where('status', 'pending');
        } elseif ($filter === 'approved') {
            $query->where('status', 'approved');
        } elseif ($filter === 'rejected') {
            $query->where('status', 'rejected');
        } elseif ($filter === 'revision') {
            $query->where('status', 'revision');
        }
        // 'all' doesn't need additional filter

        $pengajuan = $query->orderBy('tanggal_pengajuan', 'asc')->paginate(10);

        return view('approval.index', compact('pengajuan'));
    }

    public function approve(Request $request, Pengajuan $pengajuan)
    {
        if (!Auth::user()->isApprover() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini tidak dapat disetujui.');
        }

        $request->validate([
            'catatan_approval' => 'nullable|string'
        ]);

        $pengajuan->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'catatan_approval' => $request->catatan_approval,
            'tanggal_approval' => now()
        ]);

        // Update revision history if this was previously revised
        DB::table('revision_history')
            ->where('pengajuan_id', $pengajuan->id)
            ->whereNull('tanggal_resolved')
            ->update([
                'status_after' => 'approved',
                'tanggal_resolved' => now(),
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, Pengajuan $pengajuan)
    {
        if (!Auth::user()->isApprover() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini tidak dapat ditolak.');
        }

        $request->validate([
            'catatan_approval' => 'required|string'
        ]);

        $pengajuan->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'catatan_approval' => $request->catatan_approval,
            'tanggal_approval' => now()
        ]);

        // Update revision history if this was previously revised
        DB::table('revision_history')
            ->where('pengajuan_id', $pengajuan->id)
            ->whereNull('tanggal_resolved')
            ->update([
                'status_after' => 'rejected',
                'tanggal_resolved' => now(),
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function revision(Request $request, $id)
    {
        \Log::info('Revision method called', ['id' => $id, 'request' => $request->all()]);
        
        $request->validate([
            'catatan' => 'required|string|max:500',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        \Log::info('Pengajuan found', ['pengajuan' => $pengajuan->toArray()]);
        
        // Update status pengajuan
        $pengajuan->update([
            'status' => 'revision',
            'catatan_approval' => $request->catatan,
            'approved_by' => auth()->id(),
            'tanggal_approval' => now(),
        ]);
        
        \Log::info('Pengajuan updated', ['new_status' => $pengajuan->fresh()->status]);

        // Save to permanent revision history
        DB::table('revision_history')->insert([
            'pengajuan_id' => $pengajuan->id,
            'revision_by' => auth()->id(),
            'catatan_revision' => $request->catatan,
            'tanggal_revision' => now(),
            'status_before' => 'pending', // Assuming revision comes from pending status
            'status_after' => 'revision',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        \Log::info('Revision history saved');

        return back()->with('success', 'Pengajuan telah diminta untuk direvisi dan disimpan dalam history revisi permanen.');
    }

    public function revisionHistory()
    {
        if (!Auth::user()->isApprover() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // Get all revision history for this approver using query builder
        $revisions = \DB::table('revision_history')
            ->join('pengajuan', 'revision_history.pengajuan_id', '=', 'pengajuan.id')
            ->join('users', 'pengajuan.user_id', '=', 'users.id')
            ->join('users as revisor', 'revision_history.revision_by', '=', 'revisor.id')
            ->where('revision_history.revision_by', Auth::id())
            ->select(
                'revision_history.*',
                'pengajuan.nomor_pengajuan',
                'pengajuan.judul',
                'pengajuan.total_harga',
                'pengajuan.status as current_status',
                'users.name as pengaju_name'
            )
            ->orderBy('revision_history.tanggal_revision', 'desc')
            ->paginate(15);

        // Calculate statistics using query builder
        $stats = [
            'total' => \DB::table('revision_history')->where('revision_by', Auth::id())->count(),
            'still_revision' => \DB::table('revision_history')
                ->join('pengajuan', 'revision_history.pengajuan_id', '=', 'pengajuan.id')
                ->where('revision_history.revision_by', Auth::id())
                ->where('pengajuan.status', 'revision')
                ->count(),
            'resubmitted_pending' => \DB::table('revision_history')
                ->join('pengajuan', 'revision_history.pengajuan_id', '=', 'pengajuan.id')
                ->where('revision_history.revision_by', Auth::id())
                ->where('pengajuan.status', 'pending')
                ->count(),
            'approved_after_revision' => \DB::table('revision_history')
                ->where('revision_by', Auth::id())
                ->where('status_after', 'approved')
                ->count(),
            'rejected_after_revision' => \DB::table('revision_history')
                ->where('revision_by', Auth::id())
                ->where('status_after', 'rejected')
                ->count()
        ];

        return view('approval.revision_history', compact('revisions', 'stats'));
    }
}
