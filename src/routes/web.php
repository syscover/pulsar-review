<?php

Route::group(['middleware' => ['web']], function () {
    Route::post('/pulsar/review/store/responses',    '\Syscover\Review\Controllers\ResponseController@store')->name('pulsar.review.responses_store');
    Route::get('/pulsar/review/show/review/{slug}',  '\Syscover\Review\Controllers\ReviewController@show')->name('pulsar.review.review_show');
    Route::post('/pulsar/review/store/comment',      '\Syscover\Review\Controllers\CommentController@store')->name('pulsar.review.comment_store');
});