<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('status');
        });

        DB::statement("ALTER TABLE destinations MODIFY COLUMN status ENUM('pending', 'active', 'rejected', 'maintenance') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("UPDATE destinations SET status = 'active' WHERE status = 'maintenance'");
        DB::statement("ALTER TABLE destinations MODIFY COLUMN status ENUM('pending', 'active', 'rejected') NOT NULL DEFAULT 'pending'");

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
};
