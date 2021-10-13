<?php

Route::group([
    'prefix'     => 'api/v1',
    'namespace'  => 'Botble\Member\Http\Controllers\API',
    'middleware' => ['api'],
], function () {

    Route::post('register', 'AuthenticationController@register');
    Route::post('login', 'AuthenticationController@login');

    Route::post('password/forgot', 'ForgotPasswordController@sendResetLinkEmail');

    Route::post('verify-account', 'VerificationController@verify');
    Route::post('resend-verify-account-email', 'VerificationController@resend');

    Route::group(['middleware' => ['auth:member-api']], function () {
        Route::get('logout', 'AuthenticationController@logout');
        Route::get('me', 'MemberController@getProfile');
        Route::put('me', 'MemberController@updateProfile');
        Route::post('update-avatar', 'MemberController@updateAvatar');
        Route::put('change-password', 'MemberController@updatePassword');
    });

    /**
     * Custom API
     * */
    // Login
    Route::post('member-login', 'CustomMemberController@login');
    // Register
    Route::post('member-register', 'CustomMemberController@register');
    // Active account
    Route::get('member-active-account', 'CustomMemberController@activeAccount');
    // Sent Code Reset Password
    Route::post('member-code-reset-password', 'CustomMemberController@sentCodeResetPassword');
    // Reset Password
    Route::post('member-reset-password', 'CustomMemberController@resetPassword');

    /**
     * API need Member Logged
     * */
    Route::group(['middleware' => ['auth:member-api']], function () {
        // Logout
        Route::post('member-logout', 'CustomMemberController@logout');
        // Get Profile
        Route::get('member-profile', 'CustomMemberController@getProfile');
        // Update Profile
        Route::post('member-profile', 'CustomMemberController@updateMemberProfile');
    });
});
