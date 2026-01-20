<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('contact_person')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->enum('business_type', ['guide', 'transport', 'lodging', 'equipment', 'other']);
            $table->text('description')->nullable();
            $table->boolean('is_certified')->default(false);
            $table->text('certification_details')->nullable();
            $table->enum('status', ['pending', 'verified', 'suspended'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('total_bookings')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('business_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
