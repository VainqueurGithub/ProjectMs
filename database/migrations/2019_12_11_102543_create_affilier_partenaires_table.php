<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffilierPartenairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affilier_partenaires', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Affilier');
            $table->integer('Partenaire');
            $table->integer('Service');
            $table->integer('SA');
            $table->integer('Hospitalisation');
            $table->integer('Maternite');
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
        Schema::drop('affilier_partenaires');
    }
}
