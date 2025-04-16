<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('islands', function (Blueprint $table) {
            $table->id();
            $table->string(config('hashid.field'))->unique()->nullable();
            $table->string('f_code')->unique();
            $table->foreignId('atoll_id')->constrained('atolls', 'id')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->float('area_sqm')->nullable();
            $table->foreignId('island_category_id')->nullable()->constrained('island_categories', 'id')->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();

            $table->index(config('hashid.field'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('islands');
    }
};
