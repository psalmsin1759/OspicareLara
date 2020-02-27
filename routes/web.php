<?php

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

Route::get('/hospital/login', "HospitalController@login");
Route::post('/hospital/login', "HospitalController@loginAction");

Route::get('/hospital/', "HospitalController@login");

Route::get('/hospital/register', "HospitalController@register");
Route::post('/hospital/register', "HospitalController@registerAction");

Route::get('/hospital/logout', "HospitalController@logout");

Route::group(['middleware' => 'checkuser'], function (){

    Route::get('/hospital/index', "HospitalController@index");

    Route::get('/hospital/admin', "HospitalController@allAdmin");

    Route::post('/hospital/admin/add', "HospitalController@addAdmin");
    Route::get('/hospital/admin/add', "HospitalController@allAdmin");
    Route::post('/hospital/admin/edit', "HospitalController@editAdmin");
    Route::get('/hospital/admin/edit', "HospitalController@allAdmin");
    Route::post('/hospital/admin/delete', "HospitalController@deleteAdmin");
    Route::get('/hospital/admin/delete', "HospitalController@allAdmin");


    Route::get('/hospital/doctor', "HospitalController@allDoctors");

    Route::post('/hospital/doctor/add', "HospitalController@addDoctor");
    Route::get('/hospital/doctor/add', "HospitalController@allDoctors");
    Route::post('/hospital/doctor/edit', "HospitalController@editDoctor");
    Route::get('/hospital/doctor/edit', "HospitalController@allDoctors");
    Route::post('/hospital/doctor/delete', "HospitalController@deleteDoctor");
    Route::get('/hospital/doctor/delete', "HospitalController@allDoctors");


    Route::get('/hospital/nurse', "HospitalController@allNurse");

    Route::post('/hospital/nurse/add', "HospitalController@addNurse");
    Route::get('/hospital/nurse/add', "HospitalController@allNurse");
    Route::post('/hospital/nurse/edit', "HospitalController@editNurse");
    Route::get('/hospital/nurse/edit', "HospitalController@allNurse");
    Route::post('/hospital/nurse/delete', "HospitalController@deleteNurse");
    Route::get('/hospital/nurse/delete', "HospitalController@allNurse");

    Route::get('/hospital/patient', "HospitalController@allPatient");

    Route::post('/hospital/patient/add', "HospitalController@addPatient");
    Route::get('/hospital/patient/add', "HospitalController@allPatient");
    Route::post('/hospital/patient/edit', "HospitalController@editPatient");
    Route::get('/hospital/patient/edit', "HospitalController@allPatient");
    Route::post('/hospital/patient/delete', "HospitalController@deletePatient");
    Route::get('/hospital/patient/delete', "HospitalController@allPatient");


    Route::get('/hospital/profile/edit', "HospitalController@adminProfile");
    Route::post('/hospital/profile/edit', "HospitalController@updateProfile");

    Route::get('hospital/profile/changepassword', "HospitalController@editPassword");
    Route::post('hospital/profile/changepassword/edit', "HospitalController@updatePassword");
    Route::get('hospital/profile/changepassword/edit', "HospitalController@editPassword");

    Route::get('/hospital/fund/history', "HospitalController@fundHistory");

});


Route::get('/doctor/sendMail', "DoctorController@sendMailPage");
Route::post('/doctor/sendMail', "DoctorController@sendMail");
Route::get('/doctor/forgetPassword/{code}', "DoctorController@forgetPasswordPage");
Route::post('/doctor/forgetPassword', "DoctorController@forgetPasswordRecovery");
