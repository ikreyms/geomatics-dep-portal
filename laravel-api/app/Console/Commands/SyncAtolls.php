<?php

namespace App\Console\Commands;

use App\Models\Atoll;
use App\Services\IdEncoderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncAtolls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:atolls';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add atoll data to atolls table using islands.atolls config';

    public function handle()
    {
        $atolls = config('islands.atolls');

        $this->info('Adding atolls...');
        $atollData = [];
        foreach ($atolls as $atoll) {
            $atollData[] = [
                'abbreviation' => $atoll['abbreviation'],
                'short_name' => $atoll['short_name'],
            ];
        }

        DB::transaction(function () use ($atollData) {
            foreach ($atollData as $atoll) {
                IdEncoderService::createNewModelWithHashid(Atoll::class, $atoll);
            }
        });

        $this->info("Atolls added.");
        return Command::SUCCESS;
    }
}
