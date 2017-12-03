<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTableQuestion extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_question'))
        {
            Schema::create('review_question', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('ix');
                $table->integer('id')->unsigned();
                $table->string('lang_id', 2);
                $table->integer('poll_id')->unsigned();
                $table->string('name');
                $table->text('description');

                // 1 - score
                // 2 - text
                // 3 - select (inactivated)
                $table->tinyInteger('type_id')->unsigned();
                // Max score that can to contain the review
                $table->tinyInteger('high_score')->unsigned()->nullable();

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
        Schema::dropIfExists('review_question');
    }
}