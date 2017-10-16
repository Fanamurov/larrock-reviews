<?php

namespace Larrock\ComponentReviews;

use Larrock\ComponentReviews\Requests\ReviewRequest;
use Illuminate\Support\ServiceProvider;
use Larrock\ComponentReviews\Middleware\ReviewsMiddleware;

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
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

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

        $this->app['router']->aliasMiddleware('ReviewsMiddleware', ReviewsMiddleware::class);
    }
}