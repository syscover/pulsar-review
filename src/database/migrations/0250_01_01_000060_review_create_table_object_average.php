<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTableObjectAverage extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_object_average'))
        {
            Schema::create('review_object_average', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->integer('poll_id')->unsigned();
                $table->string('object_type');
                $table->integer('object_id')->unsigned()->nullable();
                $table->string('object_name');
                $table->integer('reviews')->unsigned()->default(0);             // Total reviews
                $table->decimal('total', 10,2)->default(0);        // Total score, sum of all average reviews
                $table->decimal('average', 10,2)->default(0);      // Average of all reviews

                $table->timestamps();
                $table->softDeletes();

                $table->index(['object_type', 'object_id'], 'ix01_review_object_average');

                $table->foreign('poll_id', 'fk01_review_object_average')
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
        Schema::dropIfExists('review_object_average');
    }
}