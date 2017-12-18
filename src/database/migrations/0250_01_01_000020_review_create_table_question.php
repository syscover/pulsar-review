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
                // 1 - score
                // 2 - text
                // 3 - booleano (inactivated)
                // 4 - select (inactivated)
                $table->tinyInteger('type_id')->unsigned();
                $table->string('name');
                $table->text('description')->nullable();
                $table->integer('sort')->unsigned()->nullable();

                // Max score that can to contain the review, nullable if is a text or select type question
                $table->tinyInteger('high_score')->unsigned()->nullable();
                $table->json('data_lang')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index(['id'], 'ix01_review_question');

                $table->foreign('lang_id', 'fk01_review_question')
                    ->references('id')
                    ->on('admin_lang')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');

                $table->foreign('poll_id', 'fk02_review_question')
                    ->references('id')
                    ->on('review_poll')
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
        Schema::dropIfExists('review_question');
    }
}