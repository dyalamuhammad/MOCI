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
        Schema::create('brainstorming', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('circle_id')->nullable();
            $table->unsignedBigInteger('notulen_id')->nullable();
            $table->string('anggota');
            $table->longText('ide_1')->nullable();
            $table->longText('ide_2')->nullable();
            $table->longText('ide_3')->nullable();
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
            $table->foreign('notulen_id')->references('id')->on('notulen_dt_5')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brainstorming');
    }
};
