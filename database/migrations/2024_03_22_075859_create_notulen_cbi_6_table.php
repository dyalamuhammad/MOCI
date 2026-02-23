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

        Schema::create('notulen_cbi_6', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id')->nullable();
            $table->string('story_before');
            $table->string('story_after');
            $table->string('foto_sketsa');
            $table->string('foto_3d');
            $table->string('foto');
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
        });

        // Aktifkan kembali foreign key constraints
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nonaktifkan foreign key constraints
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('notulen_cbi_6');

        // Aktifkan kembali foreign key constraints
        Schema::enableForeignKeyConstraints();    
    }
};
