<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTablePoll extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_poll'))
        {
            Schema::create('review_poll', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->string('name');
                $table->boolean('send_notification')->default(true);                    // check if sends notification to object_mail field from review table
                $table->boolean('validate')->default(true);                             // check if you want validate reviews before add to average
                $table->tinyInteger('default_high_score')->unsigned()->default(5);
                $table->smallInteger('mailing_days')->unsigned()->default(0);           // days that review will be sent to the customer
                $table->smallInteger('expiration_days')->unsigned()->default(30);       // days that review will be expired and will be deleted

                // routes
                $table->string('review_route')->nullable();                             // route to get public review to fill poll

                // templates
                $table->string('review_email_template')->nullable();                    // email template that will set the review to send to the customer
                $table->string('comment_email_template')->nullable();                   // email template that will set the comment to send to the customer

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
        Schema::dropIfExists('review_poll');
    }
}