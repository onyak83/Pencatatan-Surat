<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('suratmasuk_id');
            $table->string('no_disposisi', 100)->unique();
            $table->uuid('dari_user_id')->nullable();
            $table->uuid('dari_pegawai_id')->nullable();
            $table->uuid('kepada_pegawai_id');
            $table->text('instruksi')->nullable();
            $table->date('batas_waktu')->nullable();
            $table->enum('status', ['dikirim','diterima','diteruskan','selesai',])->default('dikirim');
            $table->dateTime('tgl_dikirim')->nullable();
            $table->dateTime('tgl_diterima')->nullable();

            $table->timestamps();

            $table->foreign('suratmasuk_id')->references('id')->on('suratmasuks')->cascadeOnDelete();
            $table->foreign('dari_user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('dari_pegawai_id')->references('id')->on('pegawaipus')->nullOnDelete();
            $table->foreign('kepada_pegawai_id')->references('id')->on('pegawaipus')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposisis');
    }
}
