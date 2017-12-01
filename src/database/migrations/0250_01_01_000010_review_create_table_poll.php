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
                $table->string('email_template');                               // Email template that will be sent to the customer
                $table->tinyInteger('default_score')->unsigned()->nullable();
                $table->smallInteger('mailing_days')->default(0);               // Days that review will be sent to the customer
                $table->smallInteger('expiration_days')->default(30);           // Days that review will be expired and will be deleted

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