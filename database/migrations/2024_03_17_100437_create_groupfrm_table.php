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
        Schema::create('groupfrm', function (Blueprint $table) {
            $table->text('id_group');
            $table->text('nama_group');
            $table->text('npk_cord');
            $table->text('id_section');
            $table->text('part');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupfrm');
    }
};
