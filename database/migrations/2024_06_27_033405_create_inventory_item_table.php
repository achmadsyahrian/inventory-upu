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
            $table->string('code')->nullable();
            $table->string('name')->unique();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('spesification')->nullable();
            $table->enum('capacity_pk', ['0.5', '0.75', '1', '1.5', '2', '2.5', '3'])->nullable(); //jumlah PK khusus AC
            $table->string('warranty')->nullable();
            $table->integer('stock');
            $table->unsignedBigInteger('condition_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('item_types')->onDelete('set null');
            $table->foreign('condition_id')->references('id')->on('item_conditions')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('item_units')->onDelete('set null');
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
