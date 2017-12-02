<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ReviewTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(CmsPackageTableSeeder::class);
        $this->call(CmsResourceTableSeeder::class);
        $this->call(CmsAttachmentMimeSeeder::class);

        Model::reguard();
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="CmsTableSeeder"
 */