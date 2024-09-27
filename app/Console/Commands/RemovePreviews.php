<?php

namespace App\Console\Commands;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Console\Command;

class RemovePreviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove_previews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old previews from database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Reply::where('status', 'preview')->where('created_at', '<', now()->subDay())->delete();
        Thread::where('status', 'preview')->where('created_at', '<', now()->subDay())->delete();
    }
}
