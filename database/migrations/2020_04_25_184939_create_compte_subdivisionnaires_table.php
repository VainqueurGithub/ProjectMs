<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompteSubdivisionnairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compte_subdivisionnaires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('NumeroCompte');
            $table->string('Intitule');
            $table->string('ComptePricipal');
            $table->integer('Etat');
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
        Schema::drop('compte_subdivisionnaires');
    }
}
