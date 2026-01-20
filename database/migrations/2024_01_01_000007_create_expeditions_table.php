<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expeditions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location');
            $table->string('region')->nullable();
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced', 'expert']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('max_participants')->default(20);
            $table->enum('status', ['planning', 'open', 'closed', 'completed', 'cancelled'])->default('planning');
            $table->boolean('permit_required')->default(false);
            $table->text('permit_details')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index('status');
            $table->index('difficulty_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expeditions');
    }
};
