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
        Schema::create('uji_penyebab', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id')->nullable();
            $table->unsignedBigInteger('notulen_id')->nullable();
            $table->string('akar_masalah')->nullable();
            $table->longText('standar')->nullable();
            $table->longText('metode_validasi')->nullable();
            $table->string('actual')->nullable();
            $table->string('judge')->nullable();
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
            $table->foreign('notulen_id')->references('id')->on('notulen_qcc_3')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uji_penyebab');
    }
};
