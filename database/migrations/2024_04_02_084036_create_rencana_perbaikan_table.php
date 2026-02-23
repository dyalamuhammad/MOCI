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
        Schema::create('rencana_perbaikan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id')->nullable();
            $table->unsignedBigInteger('notulen_id')->nullable();
            $table->longText('what')->nullable();
            $table->longText('how')->nullable();
            $table->longText('why')->nullable();
            $table->longText('where')->nullable();
            $table->longText('who')->nullable();
            $table->longText('when')->nullable();
            $table->longText('how_much')->nullable();
            $table->longText('target_antara')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
            $table->foreign('notulen_id')->references('id')->on('notulen_qcc_4')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencana_perbaikan');
    }
};
