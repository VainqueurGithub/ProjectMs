<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicamentsservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicamentsservices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Code');
            $table->string('Libelle');
            $table->integer('Partenaire');
            $table->double('Prix');
            $table->string('Propriete');
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
        Schema::drop('medicamentsservices');
    }
}
