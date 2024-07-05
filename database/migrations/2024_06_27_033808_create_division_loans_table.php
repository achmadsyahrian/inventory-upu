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
        Schema::create('division_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_division_id');
            $table->unsignedBigInteger('to_division_id');
            $table->unsignedBigInteger('inventory_item_id');
            $table->integer('quantity');
            $table->date('loan_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->text('reason')->nullable();
            $table->enum('status', ['borrowed', 'returned']); // status barang
            $table->timestamps();
        
            $table->foreign('from_division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('to_division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('division_loans');
    }
};
