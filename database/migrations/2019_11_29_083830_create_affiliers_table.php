<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Code');
            $table->string('Nom');
            $table->string('Prenom');
            $table->string('Telephone');
            $table->string('PieceIndentite');
            $table->string('Origine');
            $table->date('DateEntree');
            $table->double('CotisationM');
            $table->double('SoinsAmbilatoire');
            $table->double('PlafondChambre');
            $table->double('PCNuit');
            $table->double('UniteMaternite');
            $table->double('ElseUniteMaternite');
            $table->double('Pharmacie');
            $table->integer('DateNaiss');
            $table->string('Adresse');
            $table->double('Medicament');
            $table->double('Lunette');
            $table->double('dents');
            $table->double('labo');
            $table->double('kinesie');
            $table->double('reanimation');
            $table->double('imagerie');
            $table->double('Hospitalisation');
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
        Schema::drop('affiliers');
    }
}
