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
        Schema::table('vendors', function (Blueprint $table) {
            if (!Schema::hasColumn('vendors', 'vendor_user_id')) {
                $table->foreignId('vendor_user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('vendors', 'can_sell')) {
                $table->boolean('can_sell')->default(false)->after('vendor_user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            if (Schema::hasColumn('vendors', 'vendor_user_id')) {
                $table->dropForeignIdFor('vendor_user_id');
            }
            if (Schema::hasColumn('vendors', 'can_sell')) {
                $table->dropColumn('can_sell');
            }
        });
    }
};
