<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Ordre');
            $table->string('Compte');
            $table->integer('TypeMvt');
            $table->date('DateOperation');
            $table->text('Libelle');
            $table->string('Piece');
            $table->double('MD');
            $table->double('MC');
            $table->integer('Etat');
            $table->integer('Exercice');
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
        Schema::drop('journals');
    }
}
