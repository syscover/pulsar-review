<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTableAverage extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_average'))
        {
            Schema::create('review_average', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->integer('poll_id')->unsigned();
                $table->integer('object_id')->unsigned()->nullable();
                $table->string('object_type');
                $table->string('name');
                $table->integer('reviews')->unsigned();             // Total reviews
                $table->decimal('average', 6,2);       // Average of all reviews

                $table->timestamps();
                $table->softDeletes();

                $table->index('object_id', 'ix01_review_average');
                $table->index('object_type', 'ix02_review_average');

                $table->foreign('poll_id', 'fk01_review_average')
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
        Schema::dropIfExists('review_average');
    }
}