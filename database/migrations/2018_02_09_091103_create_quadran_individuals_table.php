<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuadranIndividualsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quadran_individuals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quatril', 50);
            $table->string('min', 4);
            $table->string('max', 4);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('quadran_individuals');
    }
}
