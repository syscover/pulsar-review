<?php namespace Syscover\Review;

use Illuminate\Support\ServiceProvider;
use Syscover\Review\GraphQL\ReviewGraphQLServiceProvider;

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
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

        // register migrations
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // register translations
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'review');

        // register views
        $this->loadViewsFrom(__DIR__ . '/../../views', 'review');

        // register seeds
        $this->publishes([
            __DIR__ . '/../../database/seeds/' => base_path('/database/seeds')
        ], 'seeds');

        // register config files
        $this->publishes([
            __DIR__ . '/../../config/pulsar-review.php' => config_path('pulsar-review.php'),
        ]);

        // register GraphQL types and schema
        ReviewGraphQLServiceProvider::bootGraphQLTypes();
        ReviewGraphQLServiceProvider::bootGraphQLSchema();
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