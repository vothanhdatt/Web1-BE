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
     * POST BY LAP API
     * */
    //get all Categories
    Route::get('get-all-categories', 'CustomPostController@getAllCategories');
    //get profile by Categories
    Route::get('get-post-by-category', 'CustomPostController@getPostByCategory');


    /**
     * API post management
     */

    //Get Detail
    Route::get('post-detail', 'CustomPostController@getPostById');


    Route::group(['middleware' => ['auth:member-api']], function () {

        // Get all post
        Route::post('get-all-post','CustomPostController@getAllPost');
        // Create post
        Route::post('create-post', 'CustomPostController@createPost');
        // Delete post
        Route::post('delete-post', 'CustomPostController@deletePost');
    });
});
