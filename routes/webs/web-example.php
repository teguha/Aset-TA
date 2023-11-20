<?php

// Example
Route::namespace('Example')->prefix('example')->name('example.')->group(function () {
    Route::namespace('Crud')->group(function () {
        Route::grid('crud', 'CrudController', [
            'with' => ['submit','approval','tracking','print','history'],
        ]);
    });
});