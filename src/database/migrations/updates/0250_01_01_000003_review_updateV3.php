<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewUpdateV2 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(! Schema::hasColumn('review_comment', 'email_template'))
        {
            Schema::table('review_poll', function (Blueprint $table) {
                $table->dropColumn('comment_email_subject');
                $table->string('comment_route')->nullable()->after('poll_route');
                $table->renameColumn('poll_route', 'review_route');
            });

            Schema::table('review_comment', function (Blueprint $table) {
                $table->renameColumn('text', 'comment');
                $table->string('email_template')->nullable()->after('validated');
                $table->string('email_subject')->nullable()->after('email_template');
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