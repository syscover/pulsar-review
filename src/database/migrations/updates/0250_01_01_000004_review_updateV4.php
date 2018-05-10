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

        if(! Schema::hasColumn('review_review', 'review_completed_url'))
        {
            Schema::table('review_review', function (Blueprint $table) {
                $table->string('review_completed_url', 2083)->nullable()->after('review_url');
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