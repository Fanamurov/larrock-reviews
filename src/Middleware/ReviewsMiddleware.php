<?php

namespace Larrock\ComponentReviews\Middleware;

use Auth;
use Closure;
use Larrock\ComponentReviews\Facades\LarrockReviews;

class ReviewsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $reviews = LarrockReviews::getModel()->whereActive(1)->latest('created_at')->take(config('larrock.reviews.module.take', 10))->get();
        \View::share('reviews', $reviews);
        return $next($request);
    }
}
