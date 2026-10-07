<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratkeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suratkeluars', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi master
            $table->unsignedBigInteger('jenis_suratkeluar_id');
            $table->unsignedBigInteger('instansi_id');
            $table->unsignedBigInteger('sifat_surat_id');

            // Data surat
            $table->string('no_agenda', 100)->unique();
            $table->string('no_surat', 100)->unique();
            $table->date('tgl_surat');
            $table->string('perihal', 255);
            $table->string('lampiran', 255)->nullable();

            // Data khusus Surat Tugas
            $table->string('jumlah_hari_tugas', 255)->nullable();
            $table->string('tujuan_tugas', 255)->nullable();
            $table->text('maksud_tujuan_tugas')->nullable();
            $table->date('mulai_tugas')->nullable();
            $table->date('selesai_tugas')->nullable();

            // File dan keterangan
            $table->string('file_surat', 255);
            $table->text('keterangan')->nullable();

            // User pembuat
            $table->uuid('created_by');

            $table->timestamps();

            // Foreign key
            $table->foreign('jenis_suratkeluar_id')->references('id')->on('jenissuratkeluars')->restrictOnDelete();
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
        Schema::dropIfExists('suratkeluars');
    }
}
