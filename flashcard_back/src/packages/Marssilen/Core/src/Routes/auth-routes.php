<?php

use Illuminate\Support\Facades\Route;

/**
 * Auth routes.
 */
Route::group(['middleware' => ['web']], function () {
    /**
     * Redirect route.
     */
    Route::get('/', function () {
        return 'Flashcard Application';
    });
});
