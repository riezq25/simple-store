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
        DB::unprepared(
            'DROP PROCEDURE IF EXISTS AddSale;'
        );
        DB::unprepared(
            'CREATE PROCEDURE AddSale(
    IN customerId INT,
    IN productId INT,
    IN qty INT
)
BEGIN
    DECLARE unitPrice DECIMAL(15,2);
    DECLARE totalAmount DECIMAL(15,2);
    DECLARE invoiceNumber VARCHAR(20);
    DECLARE saleId INT;

    -- Retrieve unit price
    SELECT sale_price INTO unitPrice FROM products WHERE product_id = productId;
    SET totalAmount = unitPrice * qty;

    -- Generate unique invoice number
    SET invoiceNumber = CONCAT(DATE_FORMAT(NOW(), \'%Y%m%d%H%i%s\'), \'-\', customerId);

    -- Insert sale and retrieve the sale_id
    INSERT INTO sales (customer_id, total_amount, invoice_number)
    VALUES (customerId, totalAmount, invoiceNumber);
    SET saleId = LAST_INSERT_ID();  -- Get the ID of the last inserted row in sales

    -- Insert sale details
    INSERT INTO sales_details (sale_id, product_id, unit_price, quantity)
    VALUES (saleId, productId, unitPrice, qty);

    -- Update product stock
    UPDATE products
    SET stock_quantity = stock_quantity - qty
    WHERE product_id = productId;
END;'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared(
            'DROP PROCEDURE IF EXISTS AddSale;'
        );
    }
};
