<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTableQuestionAverage extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_question_average'))
        {
            Schema::create('review_question_average', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->integer('question_id')->unsigned()->nullable();
                $table->integer('reviews')->unsigned();                 // Total reviews
                $table->decimal('total', 10,2);            // Total score, sum of all average reviews
                $table->decimal('average', 10,2);          // Average of all reviews

                $table->timestamps();
                $table->softDeletes();

                // Question_id is not a foreign key because questions is a multi language table
                // onDelete('cascade') will delete review_question_average record, the registration still exists
                $table->index('reviews', 'ix01_review_question_average');
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
        Schema::dropIfExists('review_question_average');
    }
}