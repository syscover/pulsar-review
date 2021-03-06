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
                $table->integer('question_id')->unsigned();

                $table->integer('score')->unsigned()->nullable();
                $table->text('text')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('review_id', 'fk01_review_response')
                    ->references('id')
                    ->on('review_review')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->foreign('question_id', 'fk02_review_response')
                    ->references('id')
                    ->on('review_question')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
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