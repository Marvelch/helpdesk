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
            $table->unsignedBigInteger('requests_from_users')->nullable();
            $table->foreign('requests_from_users')->references('id')->on('users');
            $table->string('status')->nullable();
            $table->string('description')->nullable();
            $table->date('transaction_date');
            $table->boolean('approval_supervisor')->default(0)->nullable();
            $table->boolean('approval_manager')->default(0)->nullable();
            $table->boolean('approval_general_manager')->default(0)->nullable();
            $table->unsignedBigInteger('user_supervisor')->nullable( );
            $table->foreign('user_supervisor')->references('id')->on('users');
            $table->unsignedBigInteger('user_manager_id')->nullable( );
            $table->foreign('user_manager_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_general_manager_id')->nullable();
            $table->foreign('user_general_manager_id')->references('id')->on('users');
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('request_ticket_id')->nullable();
            $table->foreign('request_ticket_id')->references('id')->on('request_tickets');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->softDeletes();
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
