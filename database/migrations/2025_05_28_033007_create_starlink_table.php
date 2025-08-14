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
        Schema::create('starlink', function (Blueprint $table) {
            $table->id();
            $table->string('kd_region')->nullable();
            $table->string('model')->nullable();
            $table->string('nomor_seri')->nullable();
            $table->string('status')->nullable();
            $table->date('tanggal_pemasangan')->nullable();
            $table->longText('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('starlink');
    }
};
