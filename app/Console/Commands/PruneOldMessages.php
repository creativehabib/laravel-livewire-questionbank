<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Models\Setting;
use Illuminate\Console\Command;

class PruneOldMessages extends Command
{
    protected $signature = 'messages:prune';

    protected $description = 'Delete messages older than configured retention time';

    public function handle(): int
    {
        $hours = (int) Setting::get('message_retention_hours', 24);
        $cutoff = now()->subHours($hours);
        $deleted = Message::where('created_at', '<', $cutoff)->delete();
        $this->info("Deleted {$deleted} messages older than {$hours} hours.");
        return self::SUCCESS;
    }
}
