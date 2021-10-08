<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor')->unique();
            $table->string('merek');
            $table->string('model');
            $table->string('varian');
            $table->string('tahun');
            $table->string('jarak_tempuh');
            $table->string('bahan_bakar');
            $table->string('warna');
            $table->text('catatan');
            $table->string('cover_link')->nullable();
            $table->foreignId('penjual_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('alamat');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('harga');
            $table->text('keyword')->nullable();
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
        Schema::dropIfExists('units');
    }
}
