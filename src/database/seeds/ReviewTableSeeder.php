<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ReviewTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(ReviewPackageTableSeeder::class);
        $this->call(ReviewCronJobTableSeeder::class);

        Model::reguard();
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ReviewTableSeeder"
 */