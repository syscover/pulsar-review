<?php

use Illuminate\Database\Seeder;
use Syscover\Admin\Models\Resource;

class ReviewResourceSeeder extends Seeder {

    public function run()
    {
        Resource::insert([
            ['id' => 'review',              'name' => 'Review Package',     'package_id' => 250],
            ['id' => 'review-review',       'name' => 'Review',             'package_id' => 250],
            ['id' => 'review-comment',      'name' => 'Comments',           'package_id' => 250],
            ['id' => 'review-average',      'name' => 'Averages',           'package_id' => 250],
            ['id' => 'review-poll',         'name' => 'Polls',              'package_id' => 250],
            ['id' => 'review-question',     'name' => 'Questions',          'package_id' => 250],
            ['id' => 'review-preference',   'name' => 'Preferences',        'package_id' => 250],
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ReviewResourceSeeder"
 */
