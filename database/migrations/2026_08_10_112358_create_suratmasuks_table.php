<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratmasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratmasuks', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->unsignedBigInteger('instansi_id');
            $table->unsignedBigInteger('sifat_surat_id');

            $table->string('no_agenda', 100)->unique();
            $table->string('no_surat', 255);
            $table->date('tgl_surat');
            $table->date('tgl_diterima');

            $table->string('perihal', 255);
            $table->string('lampiran', 255)->nullable();
            $table->string('file_surat', 255);

            $table->text('keterangan')->nullable();
            $table->uuid('created_by');

            $table->timestamps();

            $table->foreign('instansi_id')->references('id')->on('instansis')->restrictOnDelete();
            $table->foreign('sifat_surat_id')->references('id')->on('sifatsurats')->restrictOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suratmasuks');
    }
}
