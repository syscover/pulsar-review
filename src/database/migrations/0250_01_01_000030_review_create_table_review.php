<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTableReview extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_review'))
        {
            Schema::create('review_review', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->integer('customer_id')->unsigned()->nullable();             // nullable to allow anonymous reviews
                $table->boolean('verified')->default(false);                        // check if is a verified customer
                $table->integer('object_id')->unsigned()->nullable();
                $table->string('object_type');

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
        Schema::dropIfExists('review_review');
    }
}