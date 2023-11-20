<?php

// WorkManage
Route::namespace('WorkManage')->prefix('work-manage')->name('work-manage.')->group(function () {
    Route::namespace('WorkReq')->group(function () {
        Route::grid('work-req', 'WorkReqController', [
            'with' => ['submit','approval','tracking','print','history'],
        ]);
    });
});