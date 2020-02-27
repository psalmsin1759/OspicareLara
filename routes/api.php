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

Route::post("addHospital", "AppController@addHospital");

Route::post("addHospitalAdmin", "AppController@addHospitalAdmin");

Route::post("addHospitalDoctor", "AppController@addHospitalDoctor");

Route::post("addIndependentDoctor", "AppController@addIndependentDoctor");

Route::post("loginAdmin", "AppController@loginAdmin");

Route::post("adminForgetPassword", "AppController@adminForgetPassword");

Route::post("loginDoctor", "AppController@loginDoctor");

Route::post("allHospitalAdmins", "AppController@getHospitalAdmins");

Route::post("allIndependentDoctors", "AppController@allIndependentDoctors");

Route::post("allHospitalDoctors", "AppController@allHospitalDoctors");

Route::post('saveAdminFirebaseIDAndroid', "AppController@saveAdminFirebaseIDAndroid");

Route::post('saveDoctorFirebaseIDAndroid', "AppController@saveDoctorFirebaseIDAndroid");

Route::post('pushMessageToAdmin', "AppController@pushMessageToAdmin");



//**********************************************Doctor Endpoint*************************************************** */

Route::post("doctorProfile", "AppController@doctorProfile");

Route::post("doctorUpdateProfile", "AppController@doctorUpdateProfile");

Route::post("doctorChangePassword", "AppController@doctorChangePassword");

Route::post("doctorForgetPassword", "AppController@doctorForgetPassword");

Route::post("doctorFirebaseAndroid", "AppController@doctorFirebaseAndroid");
Route::post("doctorFirebaseIOS", "AppController@doctorFirebaseIOS");
Route::post("doctorPushNotification", "AppController@doctorPushNotification");

Route::post("doctorAvailability", "AppController@doctorAvailability");

Route::post("doctorStatus", "AppController@doctorStatus");

Route::post("destroyDoctor", "AppController@deleteDoctor");

Route::post('changeDoctorPassword', "AppController@changeDoctorPassword");

Route::post('updateDoctorProfileSettings', "AppController@updateDoctorProfileSettings");

Route::post('getPatientAssignedToDoctor', "AppController@getPatientAssignedToDoctor");

Route::post('setDoctorAvailability', "AppController@setDoctorAvailability");

Route::post("getWalletBalance", "AppController@getWalletBalance");

Route::post("fundWallet", "AppController@fundWallet");


//**********************************************General Health Endpoint*************************************************** */

Route::post("addGeneralWardPatientAPI", "AppController@addGeneralWardPatientAPI");

Route::post("getGeneralWardPatient", "AppController@getGeneralWardPatient");

Route::post("addPatientInfo", "AppController@addPatientInfo");

Route::post("getLatestPatientInfo", "AppController@getLatestPatientInfo");

Route::post("getPatientInfo", "AppController@getPatientInfo");

Route::post('getAvailableDoctors', "AppController@getAvailableDoctors");

Route::post('getGeneralWardLatestPatientHistory', "AppController@getGeneralWardLatestPatientHistory");


Route::post('getGeneralWardPatientHistoryByDate', "AppController@getGeneralWardPatientHistoryByDate");

Route::post('getRecommendation', "AppController@getRecommendation");

Route::post('addRecommendation', "AppController@addRecommendation");

Route::post('addProforma', "AppController@addProforma");

Route::post('getProforma', "AppController@getProforma");

Route::post('getTransaction', "AppController@getTransaction");

//**********************************************Antenatal Endpoint*************************************************** */

Route::post("addAntenatalPatientAPI", "AppController@addAntenatalPatientAPI");

Route::post("getAntenatalPatient", "AppController@getAntenatalPatient");

Route::post("addAntenatal", "AppController@addAntenatal");

Route::post("getAntenatal", "AppController@getAntenatal");

Route::post("getMedicalSocial", "AppController@getMedicalSocial");

//**********************************************Labour*************************************************** */

Route::post("addLaborPatientAPI", "AppController@addLaborPatientAPI");

Route::post("getLaborPatient", "AppController@getLaborPatient");

Route::post("addLabor", "AppController@addLabor");

Route::post("getLabor", "AppController@getLabor");

//**********************************************Labour Endpoint*************************************************** */
Route::post("addLabourComplaint", "AppController@addLabourComplaint");

Route::post("editLabourComplaint", "AppController@editLabourComplaint");

Route::post("showLabourComplaint", "AppController@showLabourComplaint");

Route::post("showPatientLabourComplaintRecord", "AppController@showPatientLabourComplaintRecord");

Route::post("addLabourPlan", "AppController@addLabourPlan");

Route::post("editLabourPlan", "AppController@editLabourPlan");

Route::post("showLabourPlan", "AppController@showLabourPlan");

Route::post("destroyLabourPlan", "AppController@deleteLabourPlan");

Route::post("showPatientLabourPlanRecord", "AppController@showPatientLabourPlanRecord");

Route::post("addLabourCategory", "AppController@addLabourCategory");

Route::post("editLabourCategory", "AppController@editLabourCategory");

Route::post("showLabourCategory", "AppController@showLabourCategory");

Route::post("destroyLabourCategory", "AppController@deleteLabourCategory");

//**********************************************Labour Vaginal Exam Endpoint*************************************************** */
Route::post("addLabourVaginalExam", "AppController@addLabourVaginalExam");

Route::post("editLabourVaginalExam", "AppController@editLabourVaginalExam");

Route::post("showLabourVaginalExam", "AppController@showLabourVaginalExam");

Route::post("destroyLabourVaginalExam", "AppController@deleteLabourVaginalExam");

Route::post("showPatientLabourVaginalExamRecord", "AppController@showPatientLabourVaginalExamRecord");

//**********************************************Partograph Endpoint*************************************************** */

Route::post("addLabourPartograph", "AppController@addLabourPartograph");

Route::post("editLabourPartograph", "AppController@editLabourPartograph");

Route::post("showLabourPartograph", "AppController@showLabourPartograph");

Route::post("destroyLabourPartograph", "AppController@deleteLabourPartograph");

Route::post("allLabourPartograph", "AppController@allLabourPartograph");

Route::post("showLabourPartograph", "AppController@showLabourPartograph");

Route::post("patientLabourPartograph", "AppController@patientLabourPartograph");

//**********************************************Delivery Summary Endpoint*************************************************** */
Route::post("addDeliverySummary", "AppController@addDeliverySummary");

Route::post("editDeliverySummary", "AppController@editDeliverySummary");

Route::post("showDeliverySummary", "AppController@showDeliverySummary");

Route::post("destroyDeliverySummary", "AppController@deleteDeliverySummary");

Route::post("allDeliverySummary", "AppController@allDeliverySummary");


//**********************************************Discharge Summary Endpoint*************************************************** */
Route::post("addDischargeSummary", "AppController@addDischargeSummary");

Route::post("editDischargeSummary", "AppController@editDischargeSummary");

Route::post("showDischargeSummary", "AppController@showDischargeSummary");

Route::post("destroyDischargeSummary", "AppController@deleteDischargeSummary");

Route::post("allDischargeSummary", "AppController@allDischargeSummary");


//**********************************************Labour Assessment Endpoint*************************************************** */
Route::post("addLabourAssessment", "AppController@addLabourAssessment");

Route::post("editLabourAssessment", "AppController@editLabourAssessment");

Route::post("showLabourAssessment", "AppController@showLabourAssessment");

Route::post("destroyLabourAssessment", "AppController@deleteLabourAssessment");

Route::post("allLabourAssessment", "AppController@allLabourAssessment");


//**********************************************Medical History Endpoint*************************************************** */

Route::post("allPatientsMedicalHistory", "AppController@allPatientsMedicalHistory");

Route::post("addMedicalHistory", "AppController@addMedicalHistory");

Route::post("editMedicalHistory", "AppController@editMedicalHistory");

Route::post("showMedicalHistory", "AppController@showMedicalHistory");
