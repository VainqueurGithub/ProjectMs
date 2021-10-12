<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartenairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partenaires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Partenaire');
            $table->string('Type');
            $table->double('AdhesionMin');
            $table->string('Code');
            $table->string('ModePasse');
            $table->integer('Etat');
            $table->integer('Auteur');
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
        Schema::drop('partenaires');
    }
}
