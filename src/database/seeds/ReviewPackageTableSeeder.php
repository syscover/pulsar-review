<?php

use Illuminate\Database\Seeder;
use Syscover\Admin\Models\Package;

class ReviewPackageTableSeeder extends Seeder
{
    public function run()
    {
        Package::insert([
            ['id' => 250, 'name' => 'Review Package', 'root' => 'review', 'sort' => 250, 'active' => true]
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ReviewPackageTableSeeder"
 */