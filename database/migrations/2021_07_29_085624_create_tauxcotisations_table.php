<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTauxcotisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tauxcotisations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('param_taux');
            $table->double('param1'); // ca peut etre soit Montant forfaitaire, soit Montant Unitaire, soit Pourcentage
            $table->double('param2');//Montant Adherant, dans le cas ou l'adherant paye un montant =! des beneficaire
            $table->double('param_annee'); //Annee d'application du dit taux de cotisation
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
        Schema::dropIfExists('tauxcotisations');
    }
}
