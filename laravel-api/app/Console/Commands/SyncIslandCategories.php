<?php

namespace App\Console\Commands;

use App\Models\IslandCategory;
use App\Services\IdEncoderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncIslandCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:island-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add island categories to island_categories table using islands.categories config';

    public function handle()
    {
        $categories = config('islands.categories');

        $this->info('Adding island categories...');
        $categoryData = [];
        foreach ($categories as $category) {
            $categoryData[] = [
                'name' => $category,
            ];
        }

        DB::transaction(function() use($categoryData) {
            foreach ($categoryData as $category) {
                IdEncoderService::createNewModelWithHashid(IslandCategory::class, $category);
            }
        });
 
        $this->info("Island categories added.");
        return Command::SUCCESS;
    }
}
