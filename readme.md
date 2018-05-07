# Reviews to Laravel

[![Total Downloads](https://poser.pugx.org/syscover/pulsar-review/downloads)](https://packagist.org/packages/syscover/pulsar-review)

## Installation

Before install syscover/pulsar-review, you need install syscover/pulsar-core and syscover/pulsar-admin

**1 - After install Laravel framework, execute on console:**
```
composer require syscover/pulsar-review
```

Register service provider, on file config/app.php add to providers array
```
Syscover\Review\ReviewServiceProvider::class,
```

**2 - Execute publish command**
```
php artisan vendor:publish --provider="Syscover\Review\ReviewServiceProvider"
```

**3 - And execute migrations and seed database**
```
php artisan migrate
php artisan db:seed --class="ReviewTableSeeder"
```

**4 - Execute command to load all updates**
```
php artisan migrate --path=vendor/syscover/pulsar-review/src/database/migrations/updates
```
