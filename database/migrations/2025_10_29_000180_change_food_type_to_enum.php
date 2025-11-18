<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, update existing data to use enum values
        // Convert any existing text values to 'other' as a safe default
        DB::statement("UPDATE donations SET food_type = 'other' WHERE food_type NOT IN ('cooked', 'fresh', 'vegetables', 'fruits', 'canned', 'bread', 'dairy', 'meat', 'grains', 'other')");
        DB::statement("UPDATE requests SET food_type = 'other' WHERE food_type NOT IN ('cooked', 'fresh', 'vegetables', 'fruits', 'canned', 'bread', 'dairy', 'meat', 'grains', 'other')");

        // Now update donations table
        DB::statement("
            ALTER TABLE donations 
            MODIFY food_type ENUM('cooked', 'fresh', 'vegetables', 'fruits', 'canned', 'bread', 'dairy', 'meat', 'grains', 'other') 
            NOT NULL
        ");

        // Then, update requests table
        DB::statement("
            ALTER TABLE requests 
            MODIFY food_type ENUM('cooked', 'fresh', 'vegetables', 'fruits', 'canned', 'bread', 'dairy', 'meat', 'grains', 'other') 
            NOT NULL
        ");
    }

    public function down(): void
    {
        // Revert donations table back to VARCHAR
        DB::statement("ALTER TABLE donations MODIFY food_type VARCHAR(100) NOT NULL");

        // Revert requests table back to VARCHAR
        DB::statement("ALTER TABLE requests MODIFY food_type VARCHAR(100) NOT NULL");
    }
};

