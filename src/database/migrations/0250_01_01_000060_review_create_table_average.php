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
                $table->integer('reviews')->unsigned();             // Total reviews
                $table->decimal('average', 6,2);       // Average of all reviews

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
        Schema::dropIfExists('review_average');
    }
}