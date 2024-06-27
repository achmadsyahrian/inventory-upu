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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('type_id');
            $table->string('brand')->nullable();
            $table->integer('stock');
            $table->unsignedBigInteger('condition_id');
            $table->unsignedBigInteger('unit_id');
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('item_types')->onDelete('cascade');
            $table->foreign('condition_id')->references('id')->on('item_conditions')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('item_units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
