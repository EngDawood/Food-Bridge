<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Find and drop the foreign key constraint by name
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'delivery_tasks' 
            AND COLUMN_NAME = 'volunteer_id' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($foreignKeys)) {
            $constraintName = $foreignKeys[0]->CONSTRAINT_NAME;
            DB::statement("ALTER TABLE delivery_tasks DROP FOREIGN KEY `{$constraintName}`");
        }

        // Make volunteer_id nullable using raw SQL
        DB::statement('ALTER TABLE delivery_tasks MODIFY volunteer_id BIGINT UNSIGNED NULL');

        // Re-add foreign key constraint
        Schema::table('delivery_tasks', function (Blueprint $table) {
            $table->foreign('volunteer_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('delivery_tasks', function (Blueprint $table) {
            // Drop FK to change column back to not null
            try {
                $table->dropForeign(['volunteer_id']);
            } catch (\Throwable $e) {
                // ignore
            }
        });

        // Revert to NOT NULL (may fail if rows have NULLs)
        DB::statement('ALTER TABLE delivery_tasks MODIFY volunteer_id BIGINT UNSIGNED NOT NULL');

        Schema::table('delivery_tasks', function (Blueprint $table) {
            $table->foreign('volunteer_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
};


