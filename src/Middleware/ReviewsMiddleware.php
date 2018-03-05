<?php

namespace Larrock\ComponentReviews\Middleware;

use Cache;
use Closure;
use LarrockReviews;

class ReviewsMiddleware
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cache_key = sha1('ReviewsMiddleware');
        $reviews = Cache::rememberForever($cache_key, function () {
            return LarrockReviews::getModel()->whereActive(1)->latest('created_at')->take(config('larrock.reviews.module.take', 10))->get();
        });
        \View::share('reviews', $reviews);
        return $next($request);
    }
}