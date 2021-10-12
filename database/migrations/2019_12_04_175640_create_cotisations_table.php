<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotisations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Affilier');
            $table->double('Montant');
            $table->integer('Mois');
            $table->integer('Etat');
            $table->integer('Janvier');
            $table->integer('Fevrier');
            $table->integer('Mars');
            $table->integer('Avril');
            $table->integer('Mai');
            $table->integer('Juin');
            $table->integer('Juillet');
            $table->integer('Aout');
            $table->integer('Semptembre');
            $table->integer('Octobre');
            $table->integer('Novembre');
            $table->integer('Decembre');
            $table->integer('Datepayement');
            $table->integer('Annee');
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
        Schema::drop('cotisations');
    }
}
