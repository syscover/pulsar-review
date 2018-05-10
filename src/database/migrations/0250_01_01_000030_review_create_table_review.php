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
                $table->integer('object_id')->unsigned();
                $table->string('object_type');
                $table->string('object_name');
                $table->string('object_email')->nullable();                                 // email where will be sent the notifications and comments if has data
                $table->integer('customer_id')->unsigned()->nullable();                     // nullable to allow anonymous reviews
                $table->string('customer_name');
                $table->string('customer_email');
                $table->boolean('customer_verified')->default(false);                       // check if is a verified customer
                $table->string('email_template')->nullable();                               // email template that will sent to the customer
                $table->string('email_subject')->nullable();                                // email subject for this review
                $table->string('review_url', 2083)->nullable();                      // url to get public review to fill poll by customer
                $table->string('review_completed_url', 2083)->nullable();            // url to get public review to show to owner object
                $table->boolean('completed')->default(false);                               // check if the review was completed for the customer
                $table->boolean('validated')->default(false);                               // check if review is added

                // cron columns
                $table->timestamp('mailing')->default(DB::raw('CURRENT_TIMESTAMP'));        // date when review will be send to customer
                $table->boolean('sent')->default(false);                                    // check if review was sent
                $table->timestamp('expiration')->default(DB::raw('CURRENT_TIMESTAMP'));     // date when review will be delete if is not completed

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