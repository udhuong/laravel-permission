<?php

use Udhuong\Permission\Presentation\Http\Controllers\GetUserDetailController;

Route::prefix('api')->middleware(['auth:api', 'verify.permission:auth'])->group(function () {
    Route::get('/user-detail', [GetUserDetailController::class, 'handle']);
});
Route::prefix('api')->middleware('verify.permission:direct')->group(function () {
    Route::get('internal/user-detail', [GetUserDetailController::class, 'handle']);
});
