<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNasabahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nasabahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_ktp')->nullable();
            $table->date('ktp_terbit')->nullable();
            $table->date('ktp_berlaku_sampai')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('gelar_nasabah')->nullable();
            $table->string('nama_gadis_ibu_kandung')->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat_ktp')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('rw')->nullable();
            $table->string('rt')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('nama_pasangan')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('ktp_pasangan')->nullable();
            $table->date('tanggal_lahir_pasangan')->nullable();
            $table->string('no_hp_pasangan')->nullable();
            $table->foreignId('card_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nasabahs');
    }
}
