<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('forget-password', 'Api\ForgetPasswordController@index');

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::get('emp-photo-link/{id}', 'Api\AuthController@emp_photo_link')->name('emp-photo-link');
Route::post('recover', 'Api\AuthController@recover');

Route::post('duty-roster', 'Api\DutyRoasterController@index');

// team/schedule
Route::post('team/schedule', 'Api\ScheduleController@index');

Route::get('file/download/{id}', 'Api\FileDownloadController@download')->name('api-file-download');

Route::get('schedule-file/download/{id}', 'Api\FileDownloadController@survey_file_download')->name('api-survey-file-download');
Route::get('duty-roster/download/{vehicle_id}/{month_id}/{year_id}', 'Api\FileDownloadController@duty_roster_file_download')->name('api-duty-roster-file-download');

Route::group(['middleware' => ['jwt.auth']], function () {

    ///file/list
    Route::get('file/list', 'Api\FileDownloadController@list');

    Route::get('month/list', 'Api\MonthController@list');
    Route::get('year/list', 'Api\YearController@list');
    Route::get('team/list', 'Api\TeamController@list');
    Route::post('team/employee/list', 'Api\TeamEmployeeController@list');

    Route::get('boat/list', 'Api\BoatController@list');

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('user/detail', 'Api\UserController@user_detail');
    });

    Route::get('logout', 'Api\AuthController@logout');

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
