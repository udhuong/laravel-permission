<?php

use Udhuong\Permission\Presentation\Http\Controllers\GetUserDetailController;

Route::prefix('api')->middleware(['auth:api', 'verify.permission'])->group(function () {
    Route::get('/user-detail', [GetUserDetailController::class, 'handle']);
});
