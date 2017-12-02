<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTableResponse extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_response'))
        {
            Schema::create('review_response', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->integer('review_id')->unsigned();
                $table->integer('request_id')->unsigned();

                $table->integer('score')->unsigned()->nullable();
                $table->string('text');
                $table->string('select'); // columna para valores de un select, opción sin implementar

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_response');
    }
}