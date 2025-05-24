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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('compare_at_price', 10, 2)->nullable()->after('price');
            $table->decimal('cost_per_item', 10, 2)->nullable()->after('compare_at_price');
            $table->string('sku', 100)->nullable()->after('cost_per_item');
            $table->string('barcode', 100)->nullable()->after('sku');
            $table->string('meta_title', 255)->nullable()->after('is_active');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords', 255)->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'compare_at_price',
                'cost_per_item',
                'sku',
                'barcode',
                'meta_title',
                'meta_description',
                'meta_keywords'
            ]);
        });
    }
};
