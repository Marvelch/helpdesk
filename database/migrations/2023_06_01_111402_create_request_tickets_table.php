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
            $table->string('title')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->date('deadline')->nullable();
            $table->integer('status')->nullable();
            $table->integer('approvement')->nullable();
            $table->unsignedBigInteger('approvement_by_user_id');
            $table->foreign('approvement_by_user_id')->references('id')->on('users');
            $table->string('type_of_work')->nullable();
            $table->string('location')->nullable();
            $table->string('description')->nullable();
            $table->string('photo')->nullable();
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
