<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewUpdateV3 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(! Schema::hasColumn('review_comment', 'comment_url'))
        {
            Schema::table('review_comment', function (Blueprint $table) {
                $table->string('comment_url')->nullable()->after('email_subject');
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