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
        Schema::create('notulen_cbi_8', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('circle_id')->nullable();
            $table->longText('csi');
            $table->longText('cei');
            $table->longText('nps');
            $table->longText('safety');
            $table->longText('quality');
            $table->longText('cost');
            $table->longText('delivery');
            $table->longText('moral');
            $table->string('environment');
            $table->timestamps();

            $table->foreign('circle_id')->references('id')->on('circles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notulen_cbi_8');
    }
};
