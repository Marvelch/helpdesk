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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('unique')->unique();
            $table->string('full_name');
            $table->string('company');
            $table->integer('total_visitor');
            $table->string('visitor_name');
            $table->string('purpose_of_visit');
            $table->date('visit_date');
            $table->time('expected_arrival_time');
            $table->string('assign_to')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('signature_visitor')->nullable();
            $table->string('signature_employee')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
