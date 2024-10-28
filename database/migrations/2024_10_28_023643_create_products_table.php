<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_code', 50)
                ->unique();
            $table->string('product_name', 255);
            $table->foreignId('category_id')
                ->constrained(Category::$table, Category::$primaryKey);
            $table->string('product_image', 255)
                ->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->integer('stock_quantity')
                ->default(0);
            $table->integer('reorder_level')
                ->default(10);
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
