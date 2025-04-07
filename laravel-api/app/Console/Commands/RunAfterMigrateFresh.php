<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunAfterMigrateFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:after-fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup system administrator account, sync island_categories, islands, atolls';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('setup:admin');
        $this->call('sync:island-categories');
        $this->call('sync:atolls');
        $this->call('sync:islands', ['file' => 'islands.csv']);
    }
}
