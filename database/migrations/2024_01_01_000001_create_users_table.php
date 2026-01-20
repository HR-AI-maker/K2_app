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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->enum('climbing_discipline', ['trekking', 'rock', 'ice', 'mountaineering'])->nullable();
            $table->string('profile_picture_path')->nullable();
            $table->enum('user_type', ['local', 'foreign'])->default('local');
            $table->enum('membership_tier', ['pending', 'standard', 'premium', 'lifetime'])->default('pending');
            $table->enum('membership_status', ['active', 'expired', 'suspended'])->default('active');
            $table->timestamp('membership_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->index('email');
            $table->index('membership_status');
            $table->index('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
