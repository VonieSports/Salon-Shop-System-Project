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
        Schema::create('item_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->json('attributes')->nullable();
            $table->string('sku')->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('price_adjustment', 10, 2)->default(0);
            $table->integer('duration_adjustment')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_optional')->default(false);
            $table->timestamps();
            $table->index(['tenant_id', 'product_id']);
            $table->index(['tenant_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_variants');
    }
};
