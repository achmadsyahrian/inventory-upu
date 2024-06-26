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
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('name_ci');
            $table->string('division_head')->nullable();
            $table->string('dimensions')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('condition_id');
            $table->unsignedBigInteger('building_id')->nullable();
            $table->timestamps();

            $table->foreign('condition_id')->references('id')->on('division_conditions');
            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
