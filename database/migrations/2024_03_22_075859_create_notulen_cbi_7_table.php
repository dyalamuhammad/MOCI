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
        // Nonaktifkan foreign key constraints
        Schema::disableForeignKeyConstraints();

        Schema::create('notulen_cbi_7', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id')->nullable();
            $table->longText('suka');
            $table->longText('tingkatkan');
            $table->longText('pertimbangkan');
            $table->longText('tidak_mengerti');
            $table->longText('hypotesis');
            $table->longText('observation');
            $table->longText('learning');
            $table->longText('decision');
            $table->string('nama_improve');
            $table->string('nama_persona');
            $table->string('tanggal_uji');
            $table->string('iterasi');
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
        });

        // Nonaktifkan foreign key constraints
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nonaktifkan foreign key constraints
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('notulen_cbi_7');

        // Nonaktifkan foreign key constraints
        Schema::enableForeignKeyConstraints();
    }
};
