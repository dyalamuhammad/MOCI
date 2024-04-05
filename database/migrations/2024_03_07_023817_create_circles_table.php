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
        Schema::create('circles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('periode');
            $table->string('npk_leader');
            $table->string('leader');
            $table->boolean('l1');
            $table->boolean('l2');
            $table->boolean('l3');
            $table->boolean('l4');
            $table->boolean('l5');
            $table->boolean('l6');
            $table->boolean('l7');
            $table->boolean('l8');
            $table->boolean('nqi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circles');
    }
};
