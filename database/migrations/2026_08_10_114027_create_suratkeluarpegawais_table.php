<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratkeluarpegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratkeluarpegawais', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke surat keluar
            $table->uuid('suratkeluar_id');

            // Relasi ke pegawai
            $table->uuid('pegawaipu_id');

            $table->timestamps();

            // Foreign key surat keluar
            $table->foreign('suratkeluar_id')->references('id')->on('suratkeluars')->cascadeOnDelete();

            // Foreign key pegawai
            $table->foreign('pegawaipu_id')->references('id')->on('pegawaipus')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suratkeluarpegawais');
    }
}
