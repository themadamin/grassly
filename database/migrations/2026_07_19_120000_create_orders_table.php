<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * orders — a claim a merchant places against an Offer (Phase 4, Milestone A.1).
 *
 * Scaffold following the phase4-todos spec. `quantity` is an integer in the
 * offer's base unit; `price` is a SNAPSHOT at purchase in integer minor units
 * (the MoneyCast handles ÷100). `delivery_window` is added for the claim form's
 * "This week / Next week / date" picker.
 *
 * Review this as your data-layer exercise before running it.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained()->cascadeOnDelete();
            // merchant who placed the claim
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            // snapshot of the offer price at purchase, integer minor units
            $table->unsignedBigInteger('price');
            $table->string('currency', 3)->default('USD');
            $table->string('status')->default('placed');
            $table->string('delivery_window')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
