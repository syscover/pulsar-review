<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewCreateTableComment extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('review_comment'))
        {
            Schema::create('review_comment', function (Blueprint $table) {
                $table->engine = 'InnoDB';

                $table->increments('id');
                $table->integer('review_id')->unsigned();
                $table->timestamp('date')->default(DB::raw('CURRENT_TIMESTAMP'));

                // set if is a customer or owner object
                // 1 - object
                // 2 - customer
                $table->tinyInteger('owner_id')->unsigned();
                $table->string('name');
                $table->string('email');
                $table->string('text');
                $table->boolean('validated')->default(false); // Check if comment is validate by moderator

                $table->string('email_template')->nullable();
                $table->string('email_subject')->nullable();
                $table->string('comment_url', 2083)->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->foreign('review_id', 'fk01_review_comment')
                    ->references('id')
                    ->on('review_review')
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
        Schema::dropIfExists('review_comment');
    }
}