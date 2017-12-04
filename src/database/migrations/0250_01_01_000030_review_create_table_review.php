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
                $table->timestamp('date')->nullable();
                $table->integer('poll_id')->unsigned();
                $table->integer('object_id')->unsigned()->nullable();
                $table->string('object_type');
                $table->integer('customer_id')->unsigned()->nullable();                     // nullable to allow anonymous reviews
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('email_subject')->nullable();                                // Email subject for this review
                $table->boolean('verified')->default(false);                                // check if is a verified customer
                $table->decimal('average', 6,2);                               // average of all responses

                // cron columns
                $table->boolean('completed')->default(false);                               // check if the review was completed for the customer
                $table->timestamp('mailing')->default(DB::raw('CURRENT_TIMESTAMP'));        // date when review will be send to customer
                $table->timestamp('expiration')->default(DB::raw('CURRENT_TIMESTAMP'));     // data when review will be delete if is not completed

                $table->timestamps();
                $table->softDeletes();

                $table->index('object_id', 'ix01_review_review');
                $table->index('object_type', 'ix02_review_review');

                $table->foreign('poll_id', 'fk01_review_review')
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
        Schema::dropIfExists('review_review');
    }
}