<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kantors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_cabang');
            $table->integer('kode_cabang');
            $table->string('no_telepon');
            $table->text('alamat');
            $table->foreignId('pic')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('tanggal_registrasi');
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
        Schema::dropIfExists('kantors');
    }
}
