<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('cart_items', 'price_snapshot')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->decimal('price_snapshot', 10, 2)->after('quantity');
            });
        }

        if (!Schema::hasColumn('cart_items', 'session_id')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->string('session_id')->nullable()->after('user_id');
            });
        }

        if (Schema::hasColumn('cart_items', 'price')) {
            if (Schema::hasColumn('cart_items', 'price_snapshot')) {
                DB::statement('UPDATE cart_items SET price_snapshot = price WHERE price_snapshot IS NULL');
            }
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropColumn('price');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('cart_items', 'price_snapshot')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropColumn('price_snapshot');
            });
        }

        if (Schema::hasColumn('cart_items', 'session_id')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropColumn('session_id');
            });
        }

        if (!Schema::hasColumn('cart_items', 'price')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->decimal('price', 10, 2);
            });
        }
    }
};
