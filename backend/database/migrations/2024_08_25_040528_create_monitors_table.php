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
        Schema::create('monitors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_monitor');
            $table->date('tanggal_monitor');
            $table->foreignId('jenis_id')->constrained('jenis');
            $table->integer('total_rakaat');
            $table->integer('total_sukses');
            $table->integer('total_gagal');
            $table->float('persentase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitors');
    }
};
