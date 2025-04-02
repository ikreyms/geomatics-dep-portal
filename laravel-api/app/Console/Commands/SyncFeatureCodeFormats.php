<?php

namespace App\Console\Commands;

use App\Models\FeatureCodeFormat;
use Illuminate\Console\Command;

class SyncFeatureCodeFormats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:feature-code-formats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add feature code formats to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FeatureCodeFormat::create([
            'name' => 'default',
            'format' => '^LD\d{4}$',
        ]);

        $this->info('Added feature code formats...');
        return Command::SUCCESS;
    }
}
