<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputaspirasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputaspirasi', function (Blueprint $table) {
            $table->id();

            $table->string('nisn', 10);
            $table->foreign('nisn')
                ->references('nisn')
                ->on('siswa')
                ->cascadeOnDelete();

            $table->foreignId('kategori_id')
                ->constrained('kategori')
                ->cascadeOnDelete();

            $table->string('lokasi');
            $table->text('keterangan');
            $table->date('tgl_input');

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
        Schema::dropIfExists('inputaspirasi');
    }
}
