<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriquemedicamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historiquemedicaments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Medicament');
            $table->double('Prix');
            $table->date('Debut');
            $table->date('Fin');
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
        Schema::drop('historiquemedicaments');
    }
}
