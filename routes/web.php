<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Backend\EmailTemplates\EmailTemplatesController;
use App\Http\Controllers\Backend\Pages\PagesController;

/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);
// Route::get('/admin/email-templates', [LanguageController::class, 'swap']);
Route::post('/update_data',[EmailTemplatesController::class, 'update_data']);
Route::post('/get_data',[EmailTemplatesController::class, 'get_data']);
Route::view('/admin/email-templates', 'backend.email-templates.index');
Route::POST('/admin/pages/store_data',[PagesController::class, 'store_data']);
/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});
