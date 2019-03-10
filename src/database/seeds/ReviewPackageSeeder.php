<?php

use Illuminate\Database\Seeder;
use Syscover\Admin\Models\Package;

class ReviewPackageSeeder extends Seeder
{
    public function run()
    {
        Package::insert([
            ['id' => 250, 'name' => 'Review Package', 'root' => 'review', 'sort' => 250, 'active' => true, 'version' => '1.0.0']
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ReviewPackageTableSeeder"
 */
