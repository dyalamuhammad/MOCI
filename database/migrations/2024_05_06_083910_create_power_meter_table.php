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
        Schema::create('power_meter', function (Blueprint $table) {
            $table->string('volt')->nullable();
            $table->string('current')->nullable();
            $table->string('daya')->nullable();
            $table->string('frekuensi')->nullable();
            $table->string('pf')->nullable();
            $table->string('energi')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('pk')->nullable();
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_meter');
    }
};
