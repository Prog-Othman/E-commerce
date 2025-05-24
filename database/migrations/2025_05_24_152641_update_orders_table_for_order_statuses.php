<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add order_status_id column
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('order_status_id')->after('user_id')->nullable()->constrained('order_statuses');
        });

        // Set default status for existing orders
        $defaultStatus = DB::table('order_statuses')->where('is_default', true)->first();
        
        if ($defaultStatus) {
            DB::table('orders')->update(['order_status_id' => $defaultStatus->id]);
        } else {
            // If no default status is found, use the first available status
            $firstStatus = DB::table('order_statuses')->first();
            if ($firstStatus) {
                DB::table('orders')->update(['order_status_id' => $firstStatus->id]);
            }
        }

        // Make the column not nullable after setting default values
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('order_status_id')->nullable(false)->change();
        });

        // Remove the old status column
        if (Schema::hasColumn('orders', 'status')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the status column
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->after('user_id')->nullable();
        });

        // Remove the foreign key constraint
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['order_status_id']);
        });

        // Drop the order_status_id column
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_status_id');
        });
    }
};
