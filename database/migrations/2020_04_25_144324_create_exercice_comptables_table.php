<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciceComptablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercice_comptables', function (Blueprint $table) {
            $table->increments('id');
            $table->date('Debut');
            $table->date('Fin');
            $table->string('Devise');
            $table->integer('NbreDecimal');
            $table->string('separateurDecimal');
            $table->string('separateurMilieu');
            $table->integer('Etat');
            $table->integer('Cloturer');
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
        Schema::drop('exercice_comptables');
    }
}
