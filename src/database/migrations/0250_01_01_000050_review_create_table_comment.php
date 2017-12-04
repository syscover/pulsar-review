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
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('text');

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