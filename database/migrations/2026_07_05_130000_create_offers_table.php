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
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('total_quantity');
            $table->unsignedInteger('remaining_quantity');
            $table->string('unit');
            // Money as integer minor units (cents); never FLOAT (CLAUDE.md).
            $table->unsignedInteger('price');
            $table->string('currency', 3)->default(Currency::USD->value);
            $table->date('available_from')->default(now());
            $table->date('available_to')->nullable();
            $table->text('description')->nullable();
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
