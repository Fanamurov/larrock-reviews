<?php

Route::post('/reviews/post', 'Larrock\ComponentReviews\ReviewsController@post')->name('reviews.post');
Route::get('/reviews', 'Larrock\ComponentReviews\ReviewsController@index')->name('reviews.all');

Route::group(['prefix' => 'admin'], function(){
    Route::resource('reviews', 'Larrock\ComponentReviews\AdminReviewsController');
});

Breadcrumbs::register('admin.'. LarrockReviews::getName() .'.index', function($breadcrumbs){
    $breadcrumbs->push(LarrockReviews::getTitle(), '/admin/'. LarrockReviews::getName());
});