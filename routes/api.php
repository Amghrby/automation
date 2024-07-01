<?php

use Amghrby\Automation\Http\Controllers\WorkflowController;

Route::prefix('api')->group(function () {
    Route::apiResource('workflows', WorkflowController::class);
});