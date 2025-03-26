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
        Schema::table('employee_category', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['category_id']);
            
            $table->dropUnique('employee_category_employee_id_category_id_unique');
            
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_category', function (Blueprint $table) {
            $table->unique(['employee_id', 'category_id']);
        });
    }
};
