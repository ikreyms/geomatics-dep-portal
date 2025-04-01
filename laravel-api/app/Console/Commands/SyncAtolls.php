<?php

namespace App\Console\Commands;

use App\Models\Atoll;
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
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::transaction(function() use($atollData) {
            foreach ($atollData as $atoll) {
                $model = new Atoll($atoll);
                $model->save();

                // Now that the model has an id, you can generate the hashid
                $model->hashid = $model->encodeHashid($model->id);
                $model->save(); // Save the hashid
            }
        });

        $this->info("Atolls added.");
        return Command::SUCCESS;
    }
}
