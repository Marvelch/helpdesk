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
        Schema::create('detail_request_hardware_software', function (Blueprint $table) {
            $table->id();
            $table->string('unique_request');
            $table->unsignedBigInteger('items_id')->nullable();
            $table->foreign('items_id')->references('id')->on('inventories');
            $table->string('items_new_request')->nullable();
            $table->integer('qty')->nullable();
            $table->string('availability')->nullable();
            $table->string('transaction_status')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_request_hardware_software');
    }
};
