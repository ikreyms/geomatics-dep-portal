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
        Schema::create('atolls', function (Blueprint $table) {
            $table->id();
            $table->string(config('hashid.field'))->unique()->nullable();
            $table->string('abbreviation')->unique();
            $table->string('short_name')->unique();

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
        Schema::dropIfExists('atolls');
    }
};
