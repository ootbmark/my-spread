<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Setting;
use Illuminate\Console\Command;

class ActivityCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity_counter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count user monthly activity and remove old data';

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
        Activity::where('created_at', '<', now()->subMonth())->delete();

        Setting::where('key', 'activity_monthly')->update(['value' => Activity::count()]);
    }
}
