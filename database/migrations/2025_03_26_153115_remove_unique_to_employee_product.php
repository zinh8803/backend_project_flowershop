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
        Schema::table('employee_product', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['product_id']);
            
            $table->dropUnique('employee_product_employee_id_product_id_unique');
            
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_product', function (Blueprint $table) {
            $table->unique(['employee_id', 'product_id']);
        });
    }
};
