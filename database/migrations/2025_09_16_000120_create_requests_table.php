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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beneficiary_id')->constrained('users')->cascadeOnDelete();
            $table->string('food_type', 100);
            $table->integer('quantity');
            $table->text('note')->nullable();
            $table->foreignId('donation_id')->nullable()->constrained('donations')->nullOnDelete();
            $table->enum('status', ['pending', 'matched', 'fulfilled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};


