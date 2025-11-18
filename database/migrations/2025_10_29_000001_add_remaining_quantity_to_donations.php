<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->integer('remaining_quantity')->nullable()->after('quantity');
        });

        // Backfill existing rows: set remaining_quantity = quantity
        DB::table('donations')
            ->whereNull('remaining_quantity')
            ->update(['remaining_quantity' => DB::raw('quantity')]);
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('remaining_quantity');
        });
    }
};


