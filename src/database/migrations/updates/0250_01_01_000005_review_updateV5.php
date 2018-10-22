<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReviewUpdateV5 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // get \Doctrine\DBAL\Schema\Table
        $doctrineTable = Schema::getConnection()->getDoctrineSchemaManager()->listTableDetails('review_review');

        // alter table "users" add constraint users_email_unique unique ("email")
        if ($doctrineTable->hasIndex('ix02_review_review'))
        {
            Schema::table('review_review', function (Blueprint $table) {
                $table->dropIndex('ix01_review_review');
                $table->dropIndex('ix02_review_review');

                DB::statement("ALTER TABLE review_review MODIFY COLUMN object_type VARCHAR(255) AFTER poll_id");

                $table->index(['object_type', 'object_id'], 'ix01_review_review');
            });
        }

        // get \Doctrine\DBAL\Schema\Table
        $doctrineTable = Schema::getConnection()->getDoctrineSchemaManager()->listTableDetails('review_object_average');

        // alter table "users" add constraint users_email_unique unique ("email")
        if ($doctrineTable->hasIndex('ix02_review_object_average'))
        {
            Schema::table('review_object_average', function (Blueprint $table) {
                $table->dropIndex('ix01_review_object_average');
                $table->dropIndex('ix02_review_object_average');

                DB::statement("ALTER TABLE review_object_average MODIFY COLUMN object_type VARCHAR(255) AFTER poll_id");

                $table->index(['object_type', 'object_id'], 'ix01_review_object_average');
            });
        }

        // get \Doctrine\DBAL\Schema\Table
        $doctrineTable = Schema::getConnection()->getDoctrineSchemaManager()->listTableDetails('review_object_question_average');

        // alter table "users" add constraint users_email_unique unique ("email")
        if (!$doctrineTable->hasIndex('ix02_review_object_question_average'))
        {
            Schema::table('review_object_question_average', function (Blueprint $table) {

                DB::statement("ALTER TABLE review_object_question_average MODIFY COLUMN object_type VARCHAR(255) AFTER question_id");

                $table->index(['object_type', 'object_id'], 'ix02_review_object_question_average');
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