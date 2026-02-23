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
        Schema::create('langkah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('periode_id')->nullable();
            $table->string('name');
            $table->date('mulai');
            $table->date('sampai');
            $table->timestamps();
        
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langkah');
    }
};
