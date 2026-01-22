<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // Relations
            $table->foreignId('vendor_id')
                  ->constrained('vendors')
                  ->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            // ENUM: category
            $table->enum('category', [
                'equipment',
                'clothing',
                'guides',
                'transport',
                'lodging',
                'food',
                'other'
            ]);

            $table->decimal('price', 10, 2);

            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_unlimited_stock')->default(false);

            // ENUM: status
            $table->enum('status', [
                'draft',
                'pending',
                'published',
                'out_of_stock',
                'discontinued'
            ])->default('draft');

            // JSON images
            $table->json('images')->nullable();

            // Approval
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            // Metrics
            $table->integer('views_count')->default(0);
            $table->integer('sales_count')->default(0);

            $table->decimal('rating', 3, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
