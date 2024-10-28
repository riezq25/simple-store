<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->string('invoice_number', 20)
                ->unique();
            $table->timestamp('sale_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('customer_id')
                ->constrained('customers', 'customer_id');
            $table->decimal('total_amount', 15, 2);
            $table->timestamps();

            // add index
            $table->index('invoice_number');
            $table->index([
                'sale_date',
                'customer_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
