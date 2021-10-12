<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldejournaliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soldejournaliers', function (Blueprint $table) {
            $table->id();
            $table->integer('Comptesudb');
            $table->integer('Souscompte')->default(0);
            $table->date('dateOperation');
            $table->date('repporterAu');
            $table->double('montant');
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
        Schema::dropIfExists('soldejournaliers');
    }
}
