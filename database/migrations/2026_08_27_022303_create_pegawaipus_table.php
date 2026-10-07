<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaipusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawaipus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('nip');
            $table->foreignId('pangkat_id')->constrained('pangkats')->cascadeOnDelete();
            $table->string('jabatan');
            $table->string('no_hp');
            $table->string('email');
            $table->string('alamat')->nullable();
            $table->string('urut_hirarki')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawaipus');
    }
}
