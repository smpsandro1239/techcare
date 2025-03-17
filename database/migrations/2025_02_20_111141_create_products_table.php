<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->longText('description');
            $table->string('sku')->unique();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->decimal('regular_price',8,2);
            $table->decimal('discounted_price',8,2)->nullable();
            $table->decimal('tax_rate',5,2)->default(0.00);
            $table->integer('stock_quantity')->default(0);
            $table->enum('stock_status',['In Stock', 'Out Of Stock'])->default('In Stock');
            $table->string('slug')->unique();
            $table->boolean('visibility')->default('0');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->enum('status',['Draft', 'Published']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
