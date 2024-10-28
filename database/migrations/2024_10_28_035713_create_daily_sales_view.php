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
        Schema::create('daily_sales_view', function (Blueprint $table) {
            DB::statement("
            CREATE VIEW daily_sales_report AS
            SELECT
                s.sale_id,
                s.invoice_number,
                s.sale_date,
                c.customer_name,
                sd.product_id,
                p.product_name,
                sd.quantity,
                s.total_amount
            FROM sales s
            JOIN sales_details sd ON s.sale_id = sd.sale_id
            JOIN customers c ON s.customer_id = c.customer_id
            JOIN products p ON sd.product_id = p.product_id
            WHERE DATE(s.sale_date) = CURDATE()
        ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS daily_sales_report");
    }
};
