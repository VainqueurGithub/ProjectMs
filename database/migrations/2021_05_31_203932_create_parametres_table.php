<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_societe');
            $table->string('nif')->default(NULL);
            $table->string('email')->default(NULL);
            $table->string('telephone')->default(NULL);
            $table->string('adresse');
            $table->string('bq_nom_un')->default(NULL);
            $table->string('bq_num_un')->default(NULL);
            $table->string('bq_nom_deux')->default(NULL);
            $table->string('bq_num_deux')->default(NULL);
            $table->string('entete')->default(NULL);
            $table->string('footer')->default(NULL);
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
        Schema::drop('parametres');
    }
}
