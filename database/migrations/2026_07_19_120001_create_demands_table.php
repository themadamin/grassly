<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * demands — the merchant buy-offer, mirror of `offers` (Phase 4, Feature B).
 *
 * Scaffold. `quantity`/`fulfilled_quantity` are integers in `unit`; `price` is
 * the target price in integer minor units (MoneyCast). Reuses OfferStatus
 * (draft/on_sale/closed) for now.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            // merchant who owns this buy-offer
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('category');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('fulfilled_quantity')->default(0);
            $table->string('unit')->default('kg');
            // target price, integer minor units
            $table->unsignedBigInteger('price');
            $table->string('currency', 3)->default('USD');
            $table->string('region');
            $table->date('needed_by')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->default('on_sale');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demands');
    }
};
