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
        Schema::create('stock_controls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_item_id');
            $table->text('description');
            $table->date('date');
            $table->enum('type', ['entry', 'distribution', 'request']);
            $table->integer('in')->nullable();
            $table->integer('out')->nullable();
            $table->integer('stock_after');
            $table->timestamps();

            $table->foreign('inventory_item_id')->references('id')->on('inventory_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_controls');
    }
};
