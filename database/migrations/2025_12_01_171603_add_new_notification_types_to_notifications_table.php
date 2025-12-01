<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql' || $driver === 'mariadb') {
            // MySQL/MariaDB: Modify enum column
            DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('match', 'update', 'alert', 'new_donation', 'new_request', 'new_delivery_task') NOT NULL");
        }
        // SQLite stores enum as VARCHAR, so no modification needed
        // The constraint is enforced at the application level
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'mysql' || $driver === 'mariadb') {
            // Revert to original enum values
            DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('match', 'update', 'alert') NOT NULL");
        }
        // SQLite: no action needed
    }
};
