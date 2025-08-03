<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateExistingRevisions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revision:migrate-existing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing revision data to permanent revision_history table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of existing revision data...');

        // Find all pengajuan that have been revised (status = 'revision' or have catatan_approval)
        $revisedPengajuan = DB::table('pengajuan')
            ->where(function($query) {
                $query->where('status', 'revision')
                      ->orWhere('catatan_approval', '!=', null);
            })
            ->whereNotNull('approved_by')
            ->get();

        $count = 0;
        foreach ($revisedPengajuan as $pengajuan) {
            // Check if this revision is already in the history table
            $existingRevision = DB::table('revision_history')
                ->where('pengajuan_id', $pengajuan->id)
                ->first();

            if (!$existingRevision) {
                // Determine the status progression
                $statusBefore = 'pending'; // Assuming revisions come from pending status
                $statusAfter = $pengajuan->status;
                $tanggalResolved = null;

                // If the current status is not 'revision', it means it has been resolved
                if ($pengajuan->status !== 'revision') {
                    $tanggalResolved = $pengajuan->tanggal_approval ?? $pengajuan->updated_at;
                }

                DB::table('revision_history')->insert([
                    'pengajuan_id' => $pengajuan->id,
                    'revision_by' => $pengajuan->approved_by,
                    'catatan_revision' => $pengajuan->catatan_approval,
                    'tanggal_revision' => $pengajuan->tanggal_approval ?? $pengajuan->updated_at,
                    'status_before' => $statusBefore,
                    'status_after' => $statusAfter,
                    'tanggal_resolved' => $tanggalResolved,
                    'created_at' => $pengajuan->created_at,
                    'updated_at' => $pengajuan->updated_at,
                ]);

                $count++;
                $this->line("Migrated pengajuan ID {$pengajuan->id}: {$pengajuan->nomor_pengajuan}");
            }
        }

        $this->info("Migration completed! {$count} revision records have been migrated to the permanent history table.");
        
        return 0;
    }
}
