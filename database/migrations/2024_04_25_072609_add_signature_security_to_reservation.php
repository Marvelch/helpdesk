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
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('signature_security')->nullable();
            $table->string('approval')->nullable()->default(0);
            $table->date('date')->nullable();
            $table->time('in')->nullable();
            $table->time('out')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
             $table->dropColumn('signature_security');
             $table->dropColumn('approval');
             $table->dropColumn('date');
             $table->dropColumn('in');
             $table->dropColumn('out');
        });
    }
};
