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
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['date', 'start_time', 'end_time']);
            $table->date('start_date'); 
            $table->date('end_date');   
            $table->unsignedTinyInteger('day_of_week')->after('end_date');
            $table->enum('shift', ['morning', 'afternoon', 'full_day'])->after('day_of_week'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->dropColumn(['day_of_week', 'shift']);
        });
    }
};
