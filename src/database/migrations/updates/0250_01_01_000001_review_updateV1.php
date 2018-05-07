<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewUpdateV1 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(! Schema::hasColumn('review_poll', 'comment_email_template'))
        {
            Schema::table('review_poll', function (Blueprint $table) {
                $table->string('comment_email_template')->nullable()->after('review_email_template');
                $table->string('comment_email_subject')->nullable()->after('comment_email_template');
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){}
}