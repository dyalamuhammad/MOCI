<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('members', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('circle_id');
        $table->string('npk_anggota');
        $table->string('l1');
        $table->string('l2');
        $table->string('l3');
        $table->string('l4');
        $table->string('l5');
        $table->string('l6');
        $table->string('l7');
        $table->string('l8');
        $table->string('nqi');
        $table->timestamps();

        $table->foreign('circle_id')->references('id')->on('circles');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
