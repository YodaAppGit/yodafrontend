<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string('no_kontrak')->nullable();
            $table->string('kondisi_unit')->nullable();
            $table->string('jenis')->nullable();
            $table->string('tujuan_penggunaan')->nullable();
            $table->string('kategori_unit')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('nomor_rangka')->nullable();
            $table->string('nama_pemilik_bpkb')->nullable();
            $table->string('nomor_bpkb')->nullable();
            $table->string('kota_terbit_bpkb')->nullable();
            $table->date('tanggal_bpkb')->nullable();
            $table->date('masa_berkalu_stnk')->nullable();
            $table->string('tenor')->nullable();
            $table->string('harga_kendaraan_baru')->nullable();
            $table->string('harga_on_the_road')->nullable();
            $table->string('max_pembiayaan_kepu')->nullable();
            $table->string('dp')->nullable();
            $table->string('pokok_pinjaman')->nullable();
            $table->string('bunga')->nullable();
            $table->string('suku_bunga_flat')->nullable();
            $table->string('suku_bunga_efektif')->nullable();
            $table->string('total_pinjaman')->nullable();
            $table->string('pembayaran_asuransi')->nullable();
            $table->string('kesertaan_asuransi')->nullable();
            $table->string('jenis_asuransi')->nullable();
            $table->string('premi_asuransi')->nullable();
            $table->string('angsuran')->nullable();
            $table->string('angsuran_pertama')->nullable();
            $table->string('biaya_administrasi')->nullable();
            $table->string('biaya_fudicia')->nullable();
            $table->string('biaya_provinsi')->nullable();
            $table->string('nilai_pertanggungan')->nullable();
            $table->string('biaya_survey_verifikasi')->nullable();
            $table->string('biaya_notaris')->nullable();
            $table->string('total_biaya')->nullable();
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
        Schema::dropIfExists('credits');
    }
}
