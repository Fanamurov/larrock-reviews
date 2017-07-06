<?php

use Larrock\ComponentReviews\ReviewsController;
use Larrock\ComponentReviews\AdminReviewsController;

Route::group(['middleware' => ['web', 'AddMenuFront', 'GetSeo', 'AddBlocksTemplate']], function(){
    Route::post('/reviews/post', [
        'as' => 'reviews.post', 'uses' => ReviewsController::class .'@post'
    ]);

    Route::get('/reviews', [
        'as' => 'reviews.all', 'uses' => ReviewsController::class .'@index'
    ]);
});

Route::group(['prefix' => 'admin', 'middleware'=> ['web', 'level:2', 'LarrockAdminMenu', 'SaveAdminPluginsData']], function(){
    Route::resource('reviews', AdminReviewsController::class);
});