<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Pivot for an offer's deliverable zones (many regions per offer). Dated
     * right after create_offers (130000) so both FKs resolve.
     */
    public function up(): void
    {
        Schema::create('offer_region', function (Blueprint $table) {
            $table->foreignId('offer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->primary(['offer_id', 'region_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_region');
    }
};
