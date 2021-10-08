<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardRefinancingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_refinancings', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->boolean('slik_checking');
            $table->boolean('assigning_credit_surveyor');
            $table->boolean('credit_surveying');
            $table->boolean('credit_approval');
            $table->boolean('credit_purchasing_order');
            $table->boolean('credit_rejected');
            $table->boolean('slik_rejected');
            $table->string('cabang_pengelola')->nullable();
            $table->integer('index');
            $table->foreignId('creator')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('unit_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('keyword')->nullable();
            $table->foreignId('pic_1')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('pic_2')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('pic_3')
                ->nullable()
                ->constrained('users')
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
        Schema::dropIfExists('card_refinancings');
    }
}
