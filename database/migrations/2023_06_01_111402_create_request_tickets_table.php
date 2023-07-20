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
        Schema::create('request_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_on_user_id')->nullable();
            $table->foreign('request_on_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('assignment_on_user_id')->nullable();
            $table->foreign('assignment_on_user_id')->references('id')->on('users');
            $table->string('title')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->date('deadline')->nullable();
            $table->unsignedBigInteger('type_of_work_id')->nullable();
            $table->foreign('type_of_work_id')->references('id')->on('work_types');
            $table->integer('status')->nullable();
            $table->integer('priority')->nullable();
            $table->string('location')->nullable();
            $table->string('description')->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_tickets');
    }
};
