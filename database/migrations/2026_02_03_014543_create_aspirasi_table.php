<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspirasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inputaspirasi_id')
                ->constrained('inputaspirasi')
                ->cascadeOnDelete();

            $table->enum('status', ['menunggu', 'proses', 'selesai'])
                ->default('menunggu');

            $table->date('tgl_aspirasi');
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
        Schema::dropIfExists('aspirasi');
    }
}
