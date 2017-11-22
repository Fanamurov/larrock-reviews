<?php

Route::post('/reviews/post', 'Larrock\ComponentReviews\ReviewsController@post')->name('reviews.post');
Route::get('/reviews', 'Larrock\ComponentReviews\ReviewsController@index')->name('reviews.all');

Route::group(['prefix' => 'admin', 'middleware'=> ['web', 'level:2', 'LarrockAdminMenu', 'SaveAdminPluginsData', 'SiteSearchAdmin']], function(){
    Route::resource('reviews', 'Larrock\ComponentReviews\AdminReviewsController');
});