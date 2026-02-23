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
        Schema::create('circles_dt_cbi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('periode');
            $table->string('npk_leader');
            $table->string('leader');
            $table->string('category');
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circles_dt_cbi');
    }
};
