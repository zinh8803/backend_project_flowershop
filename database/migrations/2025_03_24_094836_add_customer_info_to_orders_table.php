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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'name')) {
                $table->string('name')->after('id')->nullable(false);
            }
            if (!Schema::hasColumn('orders', 'email')) {
                $table->string('email')->after('name')->nullable(false);
            }
            if (!Schema::hasColumn('orders', 'phone_number')) {
                $table->string('phone_number')->after('email')->nullable();
            }
            if (!Schema::hasColumn('orders', 'address')) {
                $table->string('address')->after('phone_number')->nullable();
            }
            if (!Schema::hasColumn('orders', 'employee_id')) {
                $table->unsignedBigInteger('employee_id')->after('address')->nullable();
                $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'employee_id')) {
                $table->dropForeign(['employee_id']);
                $table->dropColumn('employee_id');
            }
            if (Schema::hasColumn('orders', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('orders', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('orders', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
            if (Schema::hasColumn('orders', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
};
