<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetTicketQuota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-ticket-quota';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset current_quota tiket ke daily_quota setiap hari';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $updated = Ticket::query()->update([
            'current_quota' => DB::raw('daily_quota'),
        ]);

        $this->info("Quota tiket di-reset: {$updated} baris.");

        return self::SUCCESS;
    }
}
