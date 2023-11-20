<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Korespondensi')->prefix('korespondensi')->name('korespondensi.')->group(function () {
    Route::namespace('Eksternal')
                ->prefix('eksternal')
                ->name('eksternal.')
                ->group(
                    function () {
                        Route::get('surat-masuk/import', 'SuratMasukController@import')->name('surat-masuk.import');
                        Route::get('surat-masuk/{id}/history', 'SuratMasukController@history')->name('surat-masuk.history');
                        Route::post('surat-masuk/importSave', 'SuratMasukController@importSave')->name('surat-masuk.importSave');
                        Route::post('surat-masuk/{id}/submitSave', 'SuratMasukController@submitSave')->name('surat-masuk.submitSave');
                        Route::grid('surat-masuk', 'SuratMasukController');

                        Route::get('surat-keluar/import', 'SuratKeluarController@import')->name('surat-keluar.import');
                        Route::get('surat-keluar/{id}/history', 'SuratKeluarController@history')->name('surat-keluar.history');
                        Route::post('surat-keluar/importSave', 'SuratKeluarController@importSave')->name('surat-keluar.importSave');
                        Route::post('surat-keluar/{id}/submitSave', 'SuratKeluarController@submitSave')->name('surat-keluar.submitSave');
                        Route::grid(
                            'surat-keluar',
                            'SuratKeluarController',
                            [
                                'with' => ['submit']
                            ]
                        );
                    }
                );

    Route::namespace('Internal')->prefix('internal')->name('internal.')->group(function () {
        //Nota Dinas
        Route::grid('nota-dinas', 'NotaDinasController', [
            'with' => ['submit','approval','tracking','print','history'],
        ]);

        //Disposisi Langsung
        Route::grid('disposisi-langsung', 'DisposisiLangsungController', [
            'with' => ['submit','approval','tracking','print','history'],
        ]);
    });
});