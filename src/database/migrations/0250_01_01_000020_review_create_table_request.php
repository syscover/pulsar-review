<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTableRequest extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_request'))
        {
            Schema::create('review_request', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('ix');
                $table->integer('id')->unsigned();
                $table->string('lang_id', 2);
                $table->integer('poll_id')->unsigned();
                $table->string('name');
                $table->text('description');

                // 1 - score
                // 2 - text
                // 3 - select, a futuro posibilidad de captar valores de un select
                $table->tinyInteger('type')->unsigned();
                $table->tinyInteger('score')->unsigned()->nullable();

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
        Schema::dropIfExists('review_request');
    }
}