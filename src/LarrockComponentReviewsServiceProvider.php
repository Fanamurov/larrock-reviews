<?php

namespace Larrock\ComponentReviews;

use Larrock\ComponentReviews\Requests\ReviewRequest;
use Illuminate\Support\ServiceProvider;

class LarrockComponentReviewsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'larrock');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/larrock')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('larrockreviews', function() {
            $class = config('larrock.components.reviews', ReviewsComponent::class);
            return new $class;
        });
        $this->app->make(ReviewRequest::class);

        $timestamp = date('Y_m_d_His', time());
        $timestamp_after = date('Y_m_d_His', time()+10);
        $migrations = [];
        if ( !class_exists('CreateReviewsTable')){
            $migrations[__DIR__.'/database/migrations/0000_00_00_000000_create_reviews_table.php'] = database_path('migrations/'.$timestamp.'_create_reviews_table.php');
        }
        if ( !class_exists('AddForeignKeysToReviewsTable')){
            $migrations[__DIR__.'/database/migrations/0000_00_00_000000_add_foreign_keys_to_reviews_table.php'] = database_path('migrations/'.$timestamp_after.'_add_foreign_keys_to_reviews_table.php');
        }

        $this->publishes($migrations, 'migrations');
    }
}