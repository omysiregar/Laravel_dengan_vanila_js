<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKariawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kariawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor_identifikasi')->unique();
            $table->text('alamat');
            $table->enum('pekerjaan', ['Unemployed', 'Programmer', 'Designer', 'Architect', 'Artist']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
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
        Schema::dropIfExists('kariawans');
    }
}
