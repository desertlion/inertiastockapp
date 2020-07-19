<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingWaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_wares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->integer('jumlah');
            $table->integer('jumlah_sebelum');
            $table->date('tanggal_masuk');
            $table->string('nama_toko');
            $table->integer('penerima');
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
        Schema::dropIfExists('incoming_wares');
    }
}
