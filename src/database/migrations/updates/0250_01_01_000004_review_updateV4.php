<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewUpdateV4 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(Schema::hasColumn('review_comment', 'owner_id'))
        {
            Schema::table('review_comment', function (Blueprint $table) {
                $table->renameColumn('owner_id', 'owner_type_id');
            });
        }

        if(Schema::hasColumn('review_poll', 'comment_route'))
        {
            Schema::table('review_poll', function (Blueprint $table) {
                $table->dropColumn('comment_route');
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