<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Followup\FollowupMonitor;
use App\Models\Followup\FollowupRegItem;
use App\Models\Master\Org\OrgStruct;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/home');
Route::get('lang/change', [Controller::class, 'change'])->name('changeLang');
Auth::routes();
Route::get('logout', [LoginController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::get(
        'auth/check',
        function () {
            return response()->json(
                [
                    'data'  => auth()->check()
                ]
            );
        }
    );
    Route::namespace('Dashboard')
        ->group(
            function () {
                Route::get('home', 'DashboardController@index')->name('home');
                Route::post('progress', 'DashboardController@progress')->name('dashboard.progress');
                Route::post('chartFinding', 'DashboardController@chartFinding')->name('dashboard.chartFinding');
                Route::post('chartFollowup', 'DashboardController@chartFollowup')->name('dashboard.chartFollowup');
                Route::post('chartStage', 'DashboardController@chartStage')->name('dashboard.chartStage');
                Route::get('language/{lang}/setLang', 'DashboardController@setLang')->name('setLang');
            }
        );

    //monitoring
    Route::namespace('Monitoring')
        ->group(
            function () {
                Route::grid(
                    'monitoring',
                    'MonitoringController',
                    [
                        'with' => ['excel', 'history', 'tracking', 'submit', 'approval'],
                        'except' => ['create', 'store']
                    ]
                );
            }
        );

    // Ajax
    Route::prefix('ajax')
        ->name('ajax.')
        ->group(
            function () {
                Route::post('saveTempFiles', 'AjaxController@saveTempFiles')->name('saveTempFiles');
                Route::get('testNotification/{emails}', 'AjaxController@testNotification')->name('testNotification');
                Route::post('userNotification', 'AjaxController@userNotification')->name('userNotification');
                Route::get('userNotification/{notification}/read', 'AjaxController@userNotificationRead')->name('userNotificationRead');
                // Ajax Modules
                Route::get('city-options', 'AjaxController@cityOptions')->name('cityOptions');
                Route::post('penilaian-category', 'AjaxController@penilaianCategoryOptions')->name('penilaianCategoryOptions');
                Route::post('city-options-root', 'AjaxController@cityOptionsRoot')->name('cityOptionsRoot');
                Route::get('jabatan-options', 'AjaxController@jabatanOptions')->name('jabatan-options');
                Route::get('jabatan-options-with-nonpkpt', 'AjaxController@jabatanWithNonPKPTOptions')->name('jabatan-options-with-nonpkpt');
                Route::post('{search}/provinceOptions', 'AjaxController@provinceOptionsBySearch')->name('provinceOptionsBySearch');
                Route::post('selectObject', 'AjaxController@selectObject')->name('selectObject');
                Route::post('{search}/selectRole', 'AjaxController@selectRole')->name('selectRole');
                Route::post('{search}/selectStruct', 'AjaxController@selectStruct')->name('selectStruct');
                Route::get('child-struct-options', 'AjaxController@childStructOptions')->name('child-struct-options');
                Route::post('{search}/selectPosition', 'AjaxController@selectPosition')->name('selectPosition');
                Route::post('{search}/selectUser', 'AjaxController@selectUser')->name('selectUser');
                Route::post('{search}/selectCity', 'AjaxController@selectCity')->name('selectCity');
                Route::post('{search}/selectProvince', 'AjaxController@selectProvince')->name('selectProvince');
                Route::post('selectProcedure', 'AjaxController@selectProcedure')->name('selectProcedure');
                Route::post('selectProcedureLangkahKerja', 'AjaxController@selectProcedureLangkahKerja')->name('selectProcedureLangkahKerja');
                Route::post('{search}/selectIctType', 'AjaxController@selectIctType')->name('selectIctType');
                Route::post('{search}/selectTypeInspection', 'AjaxController@selectTypeInspection')->name('selectTypeInspection');
                Route::post('getAuditRating', 'AjaxController@getAuditRating')->name('getAuditRating');
                Route::get('get-survey-statement', 'AjaxController@getSurveyStatement')->name('getSurveyStatement');
                Route::post('{search}/selectDokumen', 'AjaxController@selectDokumen')->name('selectDokumen');
                Route::post('{search}/selectIctObject', 'AjaxController@selectIctObject')->name('selectIctObject');
                Route::post('{search}/selectAspect', 'AjaxController@selectAspect')->name('selectAspect');
                Route::post('{search}/selectDocItem', 'AjaxController@selectDocItem')->name('selectDocItem');
                Route::post('{search}/selectCostComponent', 'AjaxController@selectCostComponent')->name('selectCostComponent');
                Route::post('{search}/selectLevelPosition', 'AjaxController@selectLevelPosition')->name('selectLevelPosition');
                Route::post('{search}/selectBankAccount', 'AjaxController@selectBankAccount')->name('selectBankAccount');
                Route::post('{search}/select-auditee-non-pkpt', 'AjaxController@selectAuditeeNonPkpt')->name('select-auditee-non-pkpt');
                Route::post('{search}/selectRiskRating', 'AjaxController@selectRiskRating')->name('selectRiskRating');
                Route::post('{search}/selectLevelDampak', 'AjaxController@selectLevelDampak')->name('selectLevelDampak');
                Route::post('{search}/selectLevelKemungkinan', 'AjaxController@selectLevelKemungkinan')->name('selectLevelKemungkinan');
                Route::post('{search}/selectKodeResiko', 'AjaxController@selectKodeResiko')->name('selectKodeResiko');
                Route::post('{search}/selectJenisResiko', 'AjaxController@selectJenisResiko')->name('selectJenisResiko');
                Route::post('{search}/selectStatusResiko', 'AjaxController@selectStatusResiko')->name('selectStatusResiko');
                Route::post('{search}/selectDetailApm', 'AjaxController@selectDetailApm')->name('selectDetailApm');
                Route::post('all/selectDetailApmByAspect', 'AjaxController@selectDetailApm2')->name('selectDetailApm2');
                Route::post('{search}/selectTrainingInstitute', 'AjaxController@selectTrainingInstitute')->name('selectTrainingInstitute');
                Route::post('{search}/selectTrainingType', 'AjaxController@selectTrainingType')->name('selectTrainingType');
                Route::post('{search}/selectExternInstance', 'AjaxController@selectExternInstance')->name('selectExternInstance');
                Route::post('{search}/selectServiceProvider', 'AjaxController@selectServiceProvider')->name('selectServiceProvider');
                Route::post('{search}/selectIacmLevelType', 'AjaxController@selectIacmLevelType')->name('selectIacmLevelType');
                Route::post('{search}/selectIacmParameterType', 'AjaxController@selectIacmParameterType')->name('selectIacmParameterType');
                Route::post('{search}/selectKategoriLangkahKerja', 'AjaxController@selectKategoriLangkahKerja')->name('selectKategoriLangkahKerja');
            }
        );

    // Setting
    Route::namespace('Setting')
        ->prefix('setting')
        ->name('setting.')
        ->group(
            function () {
                Route::namespace('Role')
                    ->group(
                        function () {
                            Route::get('role/import', 'RoleController@import')->name('role.import');
                            Route::post('role/importSave', 'RoleController@importSave')->name('role.importSave');
                            Route::get('role/{record}/permit', 'RoleController@permit')->name('role.permit');
                            Route::patch('role/{record}/grant', 'RoleController@grant')->name('role.grant');
                            Route::grid('role', 'RoleController');
                        }
                    );
                Route::namespace('Flow')
                    ->group(
                        function () {
                            Route::get('flow/import', 'FlowController@import')->name('flow.import');
                            Route::post('flow/importSave', 'FlowController@importSave')->name('flow.importSave');
                            Route::grid('flow', 'FlowController', ['with' => ['history']]);
                        }
                    );
                Route::namespace('User')
                    ->group(
                        function () {
                            Route::get('user/import', 'UserController@import')->name('user.import');
                            Route::post('user/importSave', 'UserController@importSave')->name('user.importSave');
                            Route::post('user/{record}/resetPassword', 'UserController@resetPassword')->name('user.resetPassword');
                            Route::grid('user', 'UserController');
                            Route::get('user/{record}/detail', 'UserController@detail')->name('user.detail');

                            // Pendidikan
                            Route::get('user/{record}/pendidikan', 'UserController@pendidikan')->name('user.pendidikan');
                            Route::get('user/{record}/pendidikanDetailCreate', 'UserController@pendidikanDetailCreate')->name('user.pendidikan.detailCreate');
                            Route::post('user/{id}/pendidikanDetailStore', 'UserController@pendidikanDetailStore')->name('user.pendidikan.detailStore');
                            Route::get('user/{id}/pendidikanDetailShow', 'UserController@pendidikanDetailShow')->name('user.pendidikan.detailShow');
                            Route::get('user/{id}/pendidikanDetailEdit', 'UserController@pendidikanDetailEdit')->name('user.pendidikan.detailEdit');
                            Route::post('user/{id}/pendidikanDetailUpdate', 'UserController@pendidikanDetailUpdate')->name('user.pendidikan.detailUpdate');
                            Route::delete('user/{id}/pendidikanDetailDestroy', 'UserController@pendidikanDetailDestroy')->name('user.pendidikan.detailDestroy');
                            Route::post('user/{record}/pendidikanGrid', 'UserController@pendidikanGrid')->name('user.pendidikan.grid');

                            // Sertifikasi
                            Route::get('user/{record}/sertifikasi', 'UserController@sertifikasi')->name('user.sertifikasi');
                            Route::get('user/{record}/sertifikasiDetailCreate', 'UserController@sertifikasiDetailCreate')->name('user.sertifikasi.detailCreate');
                            Route::post('user/{id}/sertifikasiDetailStore', 'UserController@sertifikasiDetailStore')->name('user.sertifikasi.detailStore');
                            Route::get('user/{id}/sertifikasiDetailShow', 'UserController@sertifikasiDetailShow')->name('user.sertifikasi.detailShow');
                            Route::get('user/{id}/sertifikasiDetailEdit', 'UserController@sertifikasiDetailEdit')->name('user.sertifikasi.detailEdit');
                            Route::post('user/{id}/sertifikasiDetailUpdate', 'UserController@sertifikasiDetailUpdate')->name('user.sertifikasi.detailUpdate');
                            Route::delete('user/{id}/sertifikasiDetailDestroy', 'UserController@sertifikasiDetailDestroy')->name('user.sertifikasi.detailDestroy');
                            Route::post('user/{record}/sertifikasiGrid', 'UserController@sertifikasiGrid')->name('user.sertifikasi.grid');



                            Route::get('profile', 'ProfileController@index')->name('profile.index');
                            Route::post('profile', 'ProfileController@updateProfile')->name('profile.updateProfile');
                            Route::get('profile/notification', 'ProfileController@notification')->name('profile.notification');
                            Route::post('profile/gridNotification', 'ProfileController@gridNotification')->name('profile.gridNotification');
                            Route::get('profile/activity', 'ProfileController@activity')->name('profile.activity');
                            Route::post('profile/gridActivity', 'ProfileController@gridActivity')->name('profile.gridActivity');
                            Route::get('profile/changePassword', 'ProfileController@changePassword')->name('profile.changePassword');
                            Route::post('profile/changePassword', 'ProfileController@updatePassword')->name('profile.updatePassword');
                        }
                    );

                Route::namespace('Activity')
                    ->group(
                        function () {
                            Route::get('activity/export', 'ActivityController@export')->name('activity.export');
                            Route::grid('activity', 'ActivityController');
                        }
                    );

                // Route::namespace('Reset')->group(function () {
                //     Route::get('reset-data', 'ResetController@index')->name('reset');
                //     Route::post('reset-data', 'ResetController@reset')->name('reset');
                // });
            }
        );

    // Master
    Route::namespace('Master')
        ->prefix('master')
        ->name('master.')
        ->group(
            function () {
                Route::namespace('Org')
                    ->prefix('org')
                    ->name('org.')
                    ->group(
                        function () {
                            Route::grid('root', 'RootController');
                            Route::get('bod/import', 'BodController@import')->name('bod.import');
                            Route::post('bod/importSave', 'BodController@importSave')->name('bod.importSave');
                            Route::grid('bod', 'BodController');

                            Route::get('department/import', 'DepartmentController@import')->name('department.import');
                            Route::post('department/importSave', 'DepartmentController@importSave')->name('department.importSave');
                            Route::grid('department', 'DepartmentController');

                            Route::get('subdepartment/import', 'SubDepartmentController@import')->name('subdepartment.import');
                            Route::post('subdepartment/importSave', 'SubDepartmentController@importSave')->name('subdepartment.importSave');
                            Route::grid('subdepartment', 'SubDepartmentController');

                            Route::get('subsection/import', 'SubSectionController@import')->name('subsection.import');
                            Route::post('subsection/importSave', 'SubSectionController@importSave')->name('subsection.importSave');
                            Route::grid('subsection', 'SubSectionController');

                            Route::get('position/import', 'PositionController@import')->name('position.import');
                            Route::post('position/importSave', 'PositionController@importSave')->name('position.importSave');
                            Route::grid('position', 'PositionController');
                        }
                    );
                Route::namespace('Geografis')
                    ->prefix('geografis')
                    ->name('geografis.')
                    ->group(
                        function () {
                            Route::grid('province', 'ProvinceController');
                            Route::grid('city', 'CityController');
                            Route::grid('district', 'DistrictController');
                        }
                    );
                Route::namespace('Coa')
                    ->group(
                        function () {
                            Route::grid('coa', 'CoaController');
                            Route::get('getDetailCOA', 'CoaController@getDetailCOA')->name('getDetailCOA');
                        }
                    );

                Route::namespace('Vendor')
                    ->group(
                        function () {
                            Route::grid('vendor', 'VendorController');
                            Route::grid('type-vendor', 'TypeVendorController');
                        }
                    );
            }
        );

    // Web Transaction Modules
    foreach (FacadesFile::allFiles(__DIR__ . '/webs') as $file) {
        require $file->getPathname();
    }
});

Route::get(
    'dev/json',
    function () {
        return [
            url('login'),
            yurl('login'),
            route('login'),
            rut('login'),
        ];
    }
);



Route::get(
    'dev/tes-email',
    function (Request $request) {
        \Mail::to(['rusman.pragma@gmail.com'])->send(new \App\Mail\TesMail());
        return $request->all();
    }
);
