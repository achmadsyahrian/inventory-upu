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
        Schema::create('division_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('inventory_item_id');
            $table->integer('quantity');
            $table->unsignedBigInteger('condition_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('condition_id')->references('id')->on('item_conditions')->onDelete('set null');
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('division_items');
    }
};
