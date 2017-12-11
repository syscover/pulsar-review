<?php

use Illuminate\Database\Seeder;
use Syscover\Admin\Models\CronJob;

class ReviewCronJobTableSeeder extends Seeder
{
    public function run()
    {
        CronJob::insert([
            [
                'id' => 250,
                'name' => 'Check mailing review',
                'package_id' => 250,
                'cron_expression' => '0 * * * *', // Se ejecuta una vez cada hora
                'command' => '\Syscover\Review\Services\Cron::checkMailingReview',
                'active' => true
            ],
            [
                'id' => 251,
                'name' => 'Check delete review',
                'package_id' => 250,
                'cron_expression' => '0 0 * * *', // Se ejecuta una vez cada día
                'command' => '\Syscover\Review\Services\Cron::checkDeleteReview',
                'active' => true
            ]
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ReviewCronJobTableSeeder"
 */