<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAyantDroitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ayant_droits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Affilier');
            $table->string('Nom');
            $table->string('Prenom');
            $table->string('Lien');
            $table->integer('Etat');
            $table->integer('Auteur');
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
        Schema::drop('ayant_droits');
    }
}
