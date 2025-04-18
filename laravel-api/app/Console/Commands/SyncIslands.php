<?php

namespace App\Console\Commands;

use App\Models\Island;
use App\Services\IdEncoderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncIslands extends Command
{
    protected $signature = 'sync:islands {file}';
    protected $description = 'Load islands data into islands table from a CSV file';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error('File not found!');
            return Command::FAILURE;
        }

        $this->info('Importing islands data...');

        // Open the CSV file for reading
        if (($handle = fopen($file, 'r')) !== false) {
            $header = fgetcsv($handle); // Read the header line

            $data = [];
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = [
                    'f_code' => $row[0],
                    'atoll_id' => $row[1],
                    'name' => ($row[2] === '' || $row[2] === ' ') ? null : $row[2],
                    'area_sqm' => $row[6],
                    'island_category_id' => $row[7],
                ];
            }

            fclose($handle);

            if (count($data) > 0) {
                DB::transaction(function () use ($data) {
                    foreach ($data as $island) {
                        IdEncoderService::createNewModelWithHashid(Island::class, $island);
                    }
                });
                $this->info(count($data) . ' islands imported successfully!');
            } else {
                $this->info('No data to import.');
            }
        } else {
            $this->error('Failed to open the file.');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
