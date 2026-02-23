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
        Schema::create('analisa_4m1e', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id')->nullable();
            $table->unsignedBigInteger('notulen_id')->nullable();
            $table->string('category');
            $table->longText('why1')->nullable();
            $table->longText('why2')->nullable();
            $table->longText('why3')->nullable();
            $table->longText('why4')->nullable();
            $table->longText('why5')->nullable();
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('analisa_4m1e');
    }
};
