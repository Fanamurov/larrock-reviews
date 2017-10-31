<?php

use Larrock\ComponentReviews\ReviewsController;
use Larrock\ComponentReviews\AdminReviewsController;

$middlewares = ['web', 'GetSeo'];
if(file_exists(base_path(). '/vendor/fanamurov/larrock-menu')){
    $middlewares[] = 'AddMenuFront';
}
if(file_exists(base_path(). '/vendor/fanamurov/larrock-blocks')){
    $middlewares[] = 'AddBlocksTemplate';
}
if(file_exists(base_path(). '/vendor/fanamurov/larrock-discount')){
    $middlewares[] = 'DiscountsShare';
}

Route::group(['middleware' => $middlewares], function(){
    Route::post('/reviews/post', [
        'as' => 'reviews.post', 'uses' => ReviewsController::class .'@post'
    ]);

    Route::get('/reviews', [
        'as' => 'reviews.all', 'uses' => ReviewsController::class .'@index'
    ]);
});

Route::group(['prefix' => 'admin', 'middleware'=> ['web', 'level:2', 'LarrockAdminMenu', 'SaveAdminPluginsData', 'SiteSearchAdmin']], function(){
    Route::resource('reviews', AdminReviewsController::class);
});