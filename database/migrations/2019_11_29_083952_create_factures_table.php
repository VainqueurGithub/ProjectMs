<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('NumFacture');
            $table->date('DateTraitement');
            $table->integer('Affilier');
            $table->integer('Beneficiaire');
            $table->date('DateTransimission');
            $table->integer('Partenaire');
            $table->double('Montant');
            $table->double('SAAT');
            $table->double('ComptantAffilier');
            $table->integer('TypeTraitement');
            $table->date('DatePayement');
            $table->string('ModePayement');
            $table->integer('Etat');
            $table->integer('Auteur');
            $table->string('Auteurtype');
            $table->integer('Mois');
            $table->integer('Annee');
            $table->integer('AnneeT');
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
        Schema::drop('factures');
    }
}
