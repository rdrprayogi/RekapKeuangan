<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\PengajuanItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Admin dapat melihat semua pengajuan
            $pengajuan = Pengajuan::with(['items', 'approver', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Pengaju hanya melihat pengajuan mereka sendiri
            $pengajuan = Pengajuan::with(['items', 'approver'])
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        return view('pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'keperluan' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.nama_barang' => 'required|string|max:255',
            'items.*.deskripsi_barang' => 'nullable|string',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generate nomor pengajuan
            $tahun = date('Y');
            $bulan = date('m');
            $lastPengajuan = Pengajuan::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count();
            $nomorUrut = str_pad($lastPengajuan + 1, 4, '0', STR_PAD_LEFT);
            $nomorPengajuan = "PENG/{$tahun}/{$bulan}/{$nomorUrut}";

            // Calculate total harga
            $totalHarga = 0;
            foreach ($request->items as $item) {
                $totalHarga += $item['jumlah'] * $item['harga_satuan'];
            }

            // Create pengajuan
            $pengajuan = Pengajuan::create([
                'nomor_pengajuan' => $nomorPengajuan,
                'user_id' => Auth::id(),
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'keperluan' => $request->keperluan,
                'total_harga' => $totalHarga,
                'tanggal_pengajuan' => now(),
                'status' => 'pending'
            ]);

            // Create pengajuan items
            foreach ($request->items as $item) {
                PengajuanItem::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_barang' => $item['nama_barang'],
                    'deskripsi_barang' => $item['deskripsi_barang'] ?? null,
                    'jumlah' => $item['jumlah'],
                    'satuan' => $item['satuan'],
                    'harga_satuan' => $item['harga_satuan'],
                    'harga_total' => $item['jumlah'] * $item['harga_satuan']
                ]);
            }

            DB::commit();
            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat membuat pengajuan.');
        }
    }

    public function show(Pengajuan $pengajuan)
    {
        // Check if user can view this pengajuan
        if ($pengajuan->user_id !== Auth::id() && !Auth::user()->isAdmin() && !Auth::user()->isApprover()) {
            abort(403);
        }

        $pengajuan->load(['items', 'user', 'approver']);
        return view('pengajuan.show', compact('pengajuan'));
    }

    public function edit(Pengajuan $pengajuan)
    {
        // Only allow editing if draft/pending/revision and user owns it or admin
        if (($pengajuan->user_id !== Auth::id() && !Auth::user()->isAdmin()) || 
            !in_array($pengajuan->status, ['draft', 'pending', 'revision'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit pengajuan ini.');
        }

        $pengajuan->load('items');
        return view('pengajuan.edit', compact('pengajuan'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        // Only allow editing if draft/pending/revision and user owns it or admin
        if (($pengajuan->user_id !== Auth::id() && !Auth::user()->isAdmin()) || 
            !in_array($pengajuan->status, ['draft', 'pending', 'revision'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit pengajuan ini.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'keperluan' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.nama_barang' => 'required|string|max:255',
            'items.*.deskripsi_barang' => 'nullable|string',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.satuan' => 'required|string|max:50',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate new total harga
            $totalHarga = 0;
            foreach ($request->items as $item) {
                $totalHarga += $item['jumlah'] * $item['harga_satuan'];
            }

            // Update pengajuan
            $updateData = [
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'keperluan' => $request->keperluan,
                'total_harga' => $totalHarga,
            ];
            
            // If status was revision, change back to pending after update
            if ($pengajuan->status === 'revision') {
                $updateData['status'] = 'pending';
                $updateData['catatan_approval'] = null;
                $updateData['approved_by'] = null;
                $updateData['tanggal_approval'] = null;
                $updateData['revision_by'] = null;
                $updateData['tanggal_revision'] = null;
            }
            
            $pengajuan->update($updateData);

            // Delete old items and create new ones
            $pengajuan->items()->delete();
            foreach ($request->items as $item) {
                PengajuanItem::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_barang' => $item['nama_barang'],
                    'deskripsi_barang' => $item['deskripsi_barang'] ?? null,
                    'jumlah' => $item['jumlah'],
                    'satuan' => $item['satuan'],
                    'harga_satuan' => $item['harga_satuan'],
                    'harga_total' => $item['jumlah'] * $item['harga_satuan']
                ]);
            }

            DB::commit();
            return redirect()->route('pengajuan.show', $pengajuan)->with('success', 'Pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui pengajuan.');
        }
    }

    public function destroy(Pengajuan $pengajuan)
    {
        // Only allow deletion if draft/pending and user owns it or admin
        if (($pengajuan->user_id !== Auth::id() && !Auth::user()->isAdmin()) || 
            !in_array($pengajuan->status, ['draft', 'pending'])) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus pengajuan ini.');
        }

        $pengajuan->delete();
        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function pending()
    {
        $user = Auth::user();
        
        $query = Pengajuan::with(['items', 'user'])->where('status', 'pending');
        
        // Filter based on user role
        if (!$user->isAdmin() && !$user->isApprover()) {
            $query->where('user_id', Auth::id());
        }
        
        // Apply sorting
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'highest':
                $query->orderBy('total_harga', 'desc');
                break;
            case 'lowest':
                $query->orderBy('total_harga', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $pengajuan = $query->paginate(10);
        
        return view('pengajuan.pending', compact('pengajuan'));
    }

    public function approved()
    {
        $user = Auth::user();
        
        $query = Pengajuan::with(['items', 'user', 'approver'])->where('status', 'approved');
        
        // Filter based on user role
        if (!$user->isAdmin() && !$user->isApprover()) {
            $query->where('user_id', Auth::id());
        }
        
        // Apply sorting
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('tanggal_approval', 'asc');
                break;
            case 'highest':
                $query->orderBy('total_harga', 'desc');
                break;
            case 'lowest':
                $query->orderBy('total_harga', 'asc');
                break;
            default:
                $query->orderBy('tanggal_approval', 'desc');
        }
        
        $pengajuan = $query->paginate(10);
        
        return view('pengajuan.approved', compact('pengajuan'));
    }

    public function revision()
    {
        $user = Auth::user();
        
        $query = Pengajuan::with(['items', 'user', 'reviser'])->where('status', 'revision');
        
        // Filter based on user role
        if (!$user->isAdmin() && !$user->isApprover()) {
            $query->where('user_id', Auth::id());
        }
        
        // Apply sorting
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('tanggal_revision', 'asc');
                break;
            case 'highest':
                $query->orderBy('total_harga', 'desc');
                break;
            case 'lowest':
                $query->orderBy('total_harga', 'asc');
                break;
            default:
                $query->orderBy('tanggal_revision', 'desc');
        }
        
        $pengajuan = $query->paginate(10);
        
        return view('pengajuan.revision', compact('pengajuan'));
    }
}
