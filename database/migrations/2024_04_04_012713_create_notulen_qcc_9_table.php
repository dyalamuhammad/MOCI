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
        Schema::create('notulen_qcc_9', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id');
            $table->string('manfaat');
            $table->longText('benefit');
            $table->string('file');
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notulen_qcc_9');
    }
};
