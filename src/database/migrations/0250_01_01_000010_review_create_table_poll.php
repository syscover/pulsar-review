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
                $table->string('email_template')->nullable();                           // Email template that will set in review to send to the customer
                $table->boolean('send_notification')->default(true);                    // Check if sends notification to object_mail field from review table
                $table->boolean('validate')->default(true);                             // Check if you want validate reviews before add to average
                $table->tinyInteger('default_high_score')->unsigned()->default(5);
                $table->smallInteger('mailing_days')->unsigned()->default(0);           // Days that review will be sent to the customer
                $table->smallInteger('expiration_days')->unsigned()->default(30);       // Days that review will be expired and will be deleted

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