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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('suplier_id');
            $table->string('supplier_name', 255);
            $table->string('contact_name', 255)
                ->nullable();
            $table->string('phone_number', 15)
                ->nullable();
            $table->string('email', 100)
                ->unique();
            $table->text('address')
                ->nullable();
            $table->char('city_code', 4);
            $table->foreign('city_code')
                ->references('city_code')
                ->on('cities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
