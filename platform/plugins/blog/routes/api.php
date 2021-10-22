<?php

Route::group([
    'middleware' => 'api',
    'prefix'     => 'api/v1',
    'namespace'  => 'Botble\Blog\Http\Controllers\API',
], function () {

    Route::get('search', 'PostController@getSearch');
    Route::get('posts', 'PostController@index');
    Route::get('categories', 'CategoryController@index');
    Route::get('tags', 'TagController@index');

    Route::get('posts/filters', 'PostController@getFilters');
    Route::get('posts/{slug}', 'PostController@findBySlug');
    Route::get('categories/filters', 'CategoryController@getFilters');
    Route::get('categories/{slug}', 'CategoryController@findBySlug');


    /**
     * API post management
     */

    //Get Detail
    Route::get('post-detail', 'CustomPostController@getPostById');

    // Create post
    Route::group(['middleware' => ['auth:member-api']], function () {
        Route::post('create-post', 'CustomPostController@createPost');
        Route::post('delete-post', 'CustomPostController@deletePost');
    });
});
