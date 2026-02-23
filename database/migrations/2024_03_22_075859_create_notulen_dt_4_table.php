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
        Schema::create('notulen_dt_4', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id')->nullable();
            $table->longText('pengguna');
            $table->longText('kebutuhan');
            $table->longText('insight');
            $table->longText('problem');
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notulen_dt_4');
    }
};
