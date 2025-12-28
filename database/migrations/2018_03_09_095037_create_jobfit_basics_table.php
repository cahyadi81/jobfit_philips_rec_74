<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobfitBasicsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobfit_basics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_competencies_id', 10);
            $table->string('jobfit_id', 1);
            $table->string('values', 3);
            $table->string('percent', 3);
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
        Schema::drop('jobfit_basics');
    }
}
