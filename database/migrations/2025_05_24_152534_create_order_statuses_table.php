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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->default('#6b7280');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default statuses
        DB::table('order_statuses')->insert([
            ['name' => 'En attente', 'color' => '#f59e0b', 'is_default' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Traitement', 'color' => '#3b82f6', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Expédié', 'color' => '#8b5cf6', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Livré', 'color' => '#10b981', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Annulé', 'color' => '#ef4444', 'is_default' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
