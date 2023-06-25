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
        Schema::create('request_hardware_software', function (Blueprint $table) {
            $table->id();
            $table->string('unique_request')->unique();
            $table->string('requests_from_users')->nullable();
            $table->string('description')->nullable();
            $table->date('transaction_date');
            $table->unsignedBigInteger('created_by_user_id');
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_hardware_software');
    }
};
