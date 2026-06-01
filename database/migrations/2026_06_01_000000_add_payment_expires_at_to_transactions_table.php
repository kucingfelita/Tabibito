<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->timestamp('payment_expires_at')->nullable()->after('status');
        });

        $hours = Transaction::paymentTimeoutHours();
        DB::table('transactions')
            ->where('status', 'pending')
            ->whereNull('payment_expires_at')
            ->update([
                'payment_expires_at' => DB::raw("DATE_ADD(created_at, INTERVAL {$hours} HOUR)"),
            ]);
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('payment_expires_at');
        });
    }
};
