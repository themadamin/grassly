<?php

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Dated after create_products (120000) so the product_id FK resolves.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            // The product this sell campaign is for. The farmer (user_id) is
            // denormalized onto the offer too, so offers can be scoped by owner
            // without joining through products.
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            // Quantity as an integer in `unit` (kg/ton). remaining_quantity starts
            // equal to total_quantity and is decremented by order claims (Phase 4).
            $table->unsignedInteger('total_quantity');
            $table->unsignedInteger('remaining_quantity');
            $table->string('unit');
            // Money as INTEGER minor units (cents); MoneyCast converts it to the
            // named currency. Never FLOAT (CLAUDE.md). Price is per `unit`.
            $table->unsignedInteger('price');
            $table->string('currency', 3)->default(Currency::USD->value);
            $table->string('region');
            $table->date('available_from')->default(now());
            $table->date('available_to')->nullable();
            $table->text('description')->nullable();
            // Only PUBLIC offers appear on the shared Market (Feature 4).
            $table->string('visibility')->default(OfferVisibility::PUBLIC->value);
            $table->string('status')->default(OfferStatus::DRAFT->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
