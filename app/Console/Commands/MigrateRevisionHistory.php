<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pengajuan;
use App\Models\RevisionHistory;

class MigrateRevisionHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:revision-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing revision data to revision_history table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting revision history migration...');

        // Get all pengajuan that have revision data
        $existingRevisions = Pengajuan::whereNotNull('revision_by')->get();
        
        $migrated = 0;
        foreach($existingRevisions as $pengajuan) {
            // Check if already migrated
            $exists = \App\Models\RevisionHistory::where('pengajuan_id', $pengajuan->id)
                                   ->where('revision_by', $pengajuan->revision_by)
                                   ->exists();
            
            if (!$exists) {
                \App\Models\RevisionHistory::create([
                    'pengajuan_id' => $pengajuan->id,
                    'revision_by' => $pengajuan->revision_by,
                    'catatan_revision' => $pengajuan->catatan_approval ?: 'Revisi diminta',
                    'tanggal_revision' => $pengajuan->tanggal_revision ?: now(),
                    'status_before' => 'pending',
                    'status_after' => $pengajuan->status === 'revision' ? null : $pengajuan->status,
                    'tanggal_resolved' => $pengajuan->status === 'revision' ? null : $pengajuan->tanggal_approval
                ]);
                $migrated++;
            }
        }
        
        $this->info("Migrated {$migrated} revision records to revision_history table.");
        $this->info("Total existing revisions found: {$existingRevisions->count()}");
        
        return 0;
    }
}
