<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->increments('id');
            $table->json('location');
            $table->string('title')->nullable();
            $table->enum('category', [1,2,3]);
            $table->text('comments')->nullable();
            $table->dateTimeTz('incidentDate');
            $table->dateTimeTz('createDate')->useCurrent();
            $table->dateTimeTz('modifyDate')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
