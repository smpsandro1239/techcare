<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('discounted_price', 8, 2)->nullable()->after('regular_price');
            $table->decimal('tax_rate', 5, 2)->nullable()->after('discounted_price');
            $table->integer('stock_quantity')->default(0)->after('tax_rate');
            $table->string('stock_status')->default('in_stock')->after('stock_quantity');
            $table->boolean('visibility')->default(true)->after('stock_status');
            $table->string('meta_title')->nullable()->after('visibility');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->boolean('status')->default(true)->after('meta_description');
            $table->string('slug')->unique()->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'discounted_price',
                'tax_rate',
                'stock_quantity',
                'stock_status',
                'visibility',
                'meta_title',
                'meta_description',
                'status',
                'slug'
            ]);
        });
    }
};
