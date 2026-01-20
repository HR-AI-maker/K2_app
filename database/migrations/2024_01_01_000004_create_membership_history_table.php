<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('membership_tier', ['standard', 'premium', 'lifetime']);
            $table->enum('status', ['active', 'expired', 'suspended', 'renewal_pending']);
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('expires_at')->useCurrent();
            $table->timestamp('renewal_reminder_sent_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_history');
    }
};
