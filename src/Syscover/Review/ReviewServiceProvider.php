<?php namespace Syscover\Review;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Syscover\Review\GraphQL\ReviewGraphQLServiceProvider;
use Syscover\Review\Services\CronService;

class ReviewServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        // register routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        // register migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // register translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'review');

        // register views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'review');

        // register seeds
        $this->publishes([
            __DIR__ . '/../../database/seeds/' => base_path('/database/seeds')
        ], 'seeds');

        // register config files
        $this->publishes([
            __DIR__ . '/../../config/pulsar-review.php' => config_path('pulsar-review.php'),
        ]);

        // call code after boot application
        $this->app->booted(function () {
            // declare schedule
            $schedule = app(Schedule::class);

            // send new reviews
            $schedule->call(function () {
                CronService::checkMailingReview();
            })->hourly();

            // delete reviews expired
            $schedule->call(function () {
                CronService::checkDeleteReview();
            })->daily();

        });
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
        //
	}
}