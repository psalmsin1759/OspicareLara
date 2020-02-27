<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 10/3/2019
 * Time: 2:36 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

use App\Hospital;
use App\Doctor;
use App\HospitalAdmin;
use App\HospitalDoctor;
use App\LabourComplaint;
use App\LabourCategory;
use App\LabourPlan;
use App\LabourVaginalExamination;
use App\LabourPartograph;
use App\LabourAssessment;
use App\DeliverySummary;
use App\DischargeSummary;
use App\MedicalHistory;
use App\AntenatalAssessment;
use App\AntenatalInvestigation;
use App\AntenatalInfo;
use App\Patient;
use App\PatientType;
use App\Mail\email;
use App\Push;
use App\doctorFirebase;

/**
 * @SWG\Swagger(
 *  schemes={"https"},
 *     host="myospicare.com/ospicare",
 *     basePath="/api",
 *   @SWG\Info(
 *     title="Ospicare Endpoints",
 *     version="1.0.0",
 *      @SWG\Contact(
 *         email="developer@qnetix.com"
 *      )
 *   )
 * )
 */


class AppController extends APIBaseController
{


    /**
     * @SWG\Post(
     *     path="/addHospital",
     *     description="",
     * @SWG\Parameter(
     *         name="name",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="address",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="city",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="state",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addHospital(Request $request){
        $name = $request->name;
        $address = $request->address;
        $city = $request->city;
        $state = $request->state;

        $hospital = Hospital::where("health_centre_name", $name)->first();

        if ($hospital == null){

            $hospital = new Hospital();
            $hospital->health_centre_name = $name;
            $hospital->address = $address;
            $hospital->city = $city;
            $hospital->state = $state;
            $hospital->save();

            return $this->sendResponse($hospital, 'success');

        }else{
            return $this->sendResponse("failed", 'Hospital Name Already Exists');
        }

    }

    /**
     * @SWG\Post(
     *     path="/addHospitalAdmin",
     *     description="",
     * @SWG\Parameter(
     *         name="names",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="phonenumber",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addHospitalAdmin(Request $request){

        $names = $request->names;
        $email = $request->email;
        $phonenumber = $request->phonenumber;
        $password = $request->password;
        $hospitalid = $request->hospitalid;

        $admin = HospitalAdmin::where("email", $email)->count();

        if ($admin == 0){

            $admin = new HospitalAdmin();
            $admin->names = $names;
            $admin->email = $email;
            $admin->phone_number = $phonenumber;
            $admin->password = $password;
            $admin->status = 'enable';
            $admin->code = md5($email);
            $admin->hospital_id = $hospitalid;
            $admin->save();

            return $this->sendResponse($admin, 'success');

        }else{

            return $this->sendResponse('Email Already Exists', 'failed');

        }
    }

    /**
     * @SWG\Post(
     *     path="/allHospitalAdmins",
     *     description="Get All Admins for single hospital",
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="Hospital ID",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function getHospitalAdmins(Request $request)
    {
        $hospitalID = $request->hospitalid;

        $check = Hospital::where('id', $hospitalID)->exists();

        if($check){
            $admins = HospitalAdmin::where('hospital_id', $hospitalID)->get();

            return $this->sendResponse($admins, 200);
        }

        return $this->sendError('Invalid Hospital ID', null, 200);
    }

    /**
     * @SWG\Post(
     *     path="/addHospitalDoctor",
     *     description="Add In-house/Hospital's doctor",
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="Admin ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="Hospital ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="names",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="sex",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="phonenumber",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="address_street",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="address_lga",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="address_state",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="specialty",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="level",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="online_consultation_fee",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="onsite_consultation_fee",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="profile",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="registering_body",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="registration_number",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *      @SWG\Parameter(
     *         name="doctor_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="thumbnail",
     *         in="formData",
     *         type="file",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function addHospitalDoctor(Request $request)
    {

        $names = $request->names;
        $email = $request->email;
        $sex = $request->sex;
        $phone_number = $request->phonenumber;
        $address_street = $request->address_street;
        $address_lga = $request->address_lga;
        $address_state = $request->address_state;
        $password = $request->password;
        $specialty = $request->specialty;
        $level = $request->level;
        $online_consultation_fee = $request->online_consultation_fee;
        $onsite_consultation_fee = $request->onsite_consultation_fee;
        $profile = $request->profile;
        $registering_body = $request->registering_body;
        $registration_number = $request->registration_number;
        $adminID = $request->adminid;
        $hospitalID = $request->hospitalid;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();


        if($checkAdmin == 1){
            $checkDoctor = Doctor::where('email', $email)->count();

            if($checkDoctor == 0){
                $doctor = new Doctor();
                $doctor->names = $names;
                $doctor->email = $email;
                $doctor->sex = $sex;
                $doctor->phone_number = $phone_number;
                $doctor->address_street= $address_street;
                $doctor->address_lga = $address_lga;
                $doctor->address_state = $address_state;
                $doctor->password = $password;
                $doctor->specialty= $specialty;
                $doctor->level = $level;
                $doctor->online_consultation_fee = $online_consultation_fee;
                $doctor->onsite_consultation_fee = $onsite_consultation_fee;
                $doctor->profile = $profile;
                $doctor->is_independent = false;
                $doctor->registering_body = $registering_body;
                $doctor->registration_number = $registration_number;
                $doctor->code = md5($email);
                $doctor->doctor_type_id = 2;


                if ($request->hasFile("thumbnail")){
                $destinationPath = "profilePhoto";
                $file = $request->thumbnail;
                
                $extension = $file->getClientOriginalExtension();
                $fileName = "doctor-" .time() . "." . $extension;
    
                $photo = $fileName;
                $photo = preg_replace('/\s+/', '', $photo);
    
                $file->move($destinationPath, $photo);

                $doctor->image_path = $photo;
            }else{
                $photo = $photo = "defaultavatar.png";
                $doctor->image_path = $photo;
            }

                $isSaved = $doctor->save();

                if($isSaved){
                    $this->addDoctorToHospital($doctor->id, $hospitalID);
                    return $this->sendResponse($doctor, 'success');
                }else{
                    return $this->sendError("Doctor info NOT added", null, 200);
                }
            }
            return $this->sendError("Doctor already exists!", null, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);

    }

    private function addDoctorToHospital($doctorID, $hospitalID){
        $add = new HospitalDoctor();
        $add->doctor_id = $doctorID;
        $add->hospital_id = $hospitalID;
        $add->save();
    }


    /**
     * @SWG\Post(
     *     path="/addIndependentDoctor",
     *     description="Sign up as Independent Doctor",
     * @SWG\Parameter(
     *         name="names",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="sex",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="phonenumber",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="specialty",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="level",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="online_consultation_fee",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="onsite_consultation_fee",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="profile",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="registering_body",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="registration_number",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *      @SWG\Parameter(
     *         name="doctor_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="thumbnail",
     *         in="formData",
     *         type="file",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function addIndependentDoctor(Request $request)
    {
        $names = $request->names;
        $email = $request->email;
        $sex = $request->sex;
        $phone_number = $request->phonenumber;
        $address_street = $request->address_street;
        $address_lga = $request->address_lga;
        $address_state = $request->address_state;
        $password = $request->password;
        $specialty = $request->specialty;
        $level = $request->level;
        $profile = $request->profile;
        $registering_body = $request->registering_body;
        $registration_number = $request->registration_number;
        $checkDoctor = Doctor::where('email', $email)->count();

        if($checkDoctor == 0){

            $doctor = new Doctor();
            $doctor->names = $names;
            $doctor->email = $email;
            $doctor->sex = $sex;
            $doctor->phone_number = $phone_number;
            $doctor->address_street= $address_street;
            $doctor->address_lga = $address_lga;
            $doctor->address_state = $address_state;
            $doctor->password = $password;
            $doctor->specialty= $specialty;
            $doctor->level = $level;
            $doctor->online_consultation_fee = "100";
            $doctor->onsite_consultation_fee = "200";
            $doctor->profile = $profile;
            $doctor->is_independent = true;
            $doctor->registering_body = $registering_body;
            $doctor->registration_number = $registration_number;
            $doctor->code = md5($email);
            $doctor->doctor_type_id = 1;



            if ($request->hasFile("thumbnail")){
                $destinationPath = "profilePhoto";
                $file = $request->thumbnail;
                
                $extension = $file->getClientOriginalExtension();
                $fileName = "doctor-" .time() . "." . $extension;
    
                $photo = $fileName;
                $photo = preg_replace('/\s+/', '', $photo);
    
                $file->move($destinationPath, $photo);

                $doctor->image_path = $photo;
            }else{
                $photo = "defaultavatar.png";
                $doctor->image_path = $photo;
            }

            $isSaved = $doctor->save();

            if($isSaved){
                return $this->sendResponse($doctor, 'success');
            }else{
                return $this->sendError("Doctor info NOT added", null, 200);
            }
        }
        return $this->sendError("Doctor already exists!", null, 200);
    }

    


    /**
     * @SWG\Post(
     *     path="/loginAdmin",
     *     description="",
     * @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function loginAdmin(Request $request){

        $email = $request->email;
        $password = $request->password;

        $count = HospitalAdmin::where("email", $email)->where("password",$password)->count();

        if($count == 1){

            $user = DB::table('hospital_admin')
                ->join('hospital', 'hospital_id', '=', 'hospital.id')
                ->select('hospital.*','hospital_admin.id as userid', 'hospital_admin.names', 'hospital_admin.email', 'hospital_admin.phone_number', 'hospital_admin.hospital_id')
                ->where('hospital_admin.email', '=', $email)
                ->where('hospital_admin.password', '=', $password)
                ->first();



            $response = [
                'status' => 'success',
                'data' => $user,
                'message' => "success"
            ];
            return Response::json($response, 200 );

        }else{

            $response = [
                'status' => 'failed',
                'data' => null,
                'message' => "Invalid Email or Password...Please try again!!!"
            ];
            return Response::json($response, 200 );

        }

    }




    /**
     * @SWG\Post(
     *     path="/doctorForgetPassword",
     *     description="Reset Password API",
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         description="Your email",
     *         required=true,
     *         
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    
    public function adminForgetPassword(Request $request)
    {
        $email = $request->email;
        $appName = 'Ospicare';

        $admin = HospitalAdmin::where("email", $email)->first();

        if ($admin == null) {


            $response = array(
                'status' => 'failed',
                'message' => 'Email Address does not exist'
            );

            return Response::json($response);

        }else{

            Mail::to($email)->send(new email($admin->names, $admin->code, $appName));

            $response = array(
                'status' => 'successful',
                'message' => 'Email Sent'
            );

            return Response::json($response);
        }
    }
    // **********************************************************Doctor Begins******************************************************


    /**
     * @SWG\Post(
     *     path="/loginDoctor",
     *     description="",
     * @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function loginDoctor(Request $request){

        $email = $request->email;
        $password = $request->password;

        $count = Doctor::where("email", $email)->where("password",$password)->count();

        if($count == 1){

            $doctor = Doctor::where("email", $email)->where("password", $password)->first();

            $response = [
                'status' => 'success',
                'data' => $doctor,
                'message' => "success"
            ];
            return Response::json($response, 200 );

        }else{

            $response = [
                'status' => 'failed',
                'data' => null,
                'message' => "Invalid Email or Password...Please try again!!!"
            ];
            return Response::json($response, 200 );

        }

    }

    /**
     * @SWG\Post(
     *     path="/allIndependentDoctors",
     *     description="Get all Independent Doctors as a super admin",
     *      @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="Admin ID",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function allIndependentDoctors(Request $request){

        $adminID = $request->adminid;

        $check = HospitalAdmin::where('id', $adminID)->count();

        if($check == 1){
            $doctors = Doctor::where("doctor_type_id", "1")->orderBy("created_at", "desc")->get();

            return $this->sendResponse($doctors, 'success');
        }
        return $this->sendError('Invalid Admin ID', null, 200);
    }



	/**
     * @SWG\Post(
     *     path="/allHospitalDoctors",
     *     description="Get all hospital doctors",
     *      @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="Hospital ID",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    
    public function allHospitalDoctors(Request $request){

        $hospitalID = $request->hospitalid;

        $check = Hospital::where('id', $hospitalID)->count();

        if($check == 1){
            $doctors = Doctor::join('hospital_doctor', 'hospital_doctor.doctor_id', '=', 'doctor.id')
            ->where("doctor.doctor_type_id", "2")
            ->where("hospital_doctor.hospital_id", $hospitalID)
            ->select("doctor.*")
            ->orderBy("created_at", "desc")->get();

            return $this->sendResponse($doctors, 'success');
        }
        return $this->sendError('Invalid Admin or Hospital ID', null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/doctorProfile",
     *     description="",
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function doctorProfile(Request $request)
    {
        $doctorID = $request->doctorid;

        $check = Doctor::where('id', $doctorID)->count();

        if($check == 1){
            $doctor = Doctor::where('id', $doctorID)->first();

            return $this->sendResponse($doctor, 200);
        }
        return $this->sendError('Invalid Doctor ID', 200);
    }





    /**
     * @SWG\Post(
     *     path="/doctorUpdateProfile",
     * @SWG\Parameter(
     *         name="phonenumber",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="address_street",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="address_lga",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="address_state",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="specialty",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="level",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="online_consultation_fee",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="onsite_consultation_fee",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Parameter(
     *         name="profile",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function doctorUpdateProfile(Request $request)
    {
        $doctorID = $request->doctorid;
        $profile = $request->profile;
        $specialty = $request->specialty;
        $level = $request->level;
        $street = $request->address_street;
        $lga = $request->address_lga;
        $state = $request->address_state;
        $online_consultation_fee = $request->online_consultation_fee;
        $onsite_consultation_fee = $request->onsite_consultation_fee;
        $phone_number = $request->phonenumber;

        $check = Doctor::where('id', $doctorID)->count();

        if($check == 1){
            $doctor = Doctor::where('id', $doctorID)->first();
            $doctor->profile = $profile;
            $doctor->phone_number = $phone_number;
            $doctor->specialty = $specialty;
            $doctor->level = $level;
            $doctor->address_street = $street;
            $doctor->address_lga = $lga;
            $doctor->address_state = $state;
            $doctor->online_consultation_fee = $online_consultation_fee;
            $doctor->onsite_consultation_fee = $onsite_consultation_fee;
            $isSaved = $doctor->save();

            if($isSaved){
                return $this->sendResponse($doctor, 200);
            }else{
                return $this->sendError("Doctor's profile not updated!", null, 200);
            }
        }
        return $this->sendError('Invalid Doctor ID', 200);
    }



    /**
     * @SWG\Post(
     *     path="/doctorChangePassword",
     *     description="Change password ",
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="oldpassword",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="newpassword",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="confirmpassword",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function doctorChangePassword(Request $request)
    {
        $doctorID = $request->doctorid;
        $oldpassword = $request->oldpassword;
        $newpassword = $request->newpassword;
        $confirmpassword = $request->confirmpassword;

        $check = Doctor::where('id', $doctorID)->where('password', $oldpassword)->count();

        if($check == 1){
            if($newpassword == $confirmpassword){
                $doctor = Doctor::where('id', $doctorID)->first();
                $doctor->password = $newpassword;
                $isSaved = $doctor->save();

                if($isSaved){
                    return $this->sendResponse($doctor, 200);
                }
                return $this->sendError("Password NOT changed", null, 200);
            }
            return $this->sendError('New password mismatch!', 200);
        }
        return $this->sendError('Invalid Doctor ID or Old password', 200);
    }



    /**
     * @SWG\Post(
     *     path="/doctorforgetPassword",
     *     description="Reset Password API",
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         type="string",
     *         description="Your email",
     *         required=true,
     *         
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    
    public function doctorForgetPassword(Request $request)
    {
        $email = $request->email;
        $appName = 'Ospicare';

        $doctor = Doctor::where("email", $email)->first();

        if ($doctor == null) {


            $response = array(
                'status' => 'failed',
                'message' => 'Email Address does not exist'
            );

            return Response::json($response);

        }else{

            Mail::to($email)->send(new email($doctor->names, $doctor->code, $appName));

            $response = array(
                'status' => 'successful',
                'message' => 'Email Sent'
            );

            return Response::json($response);
        }
    }



    /**
     * @SWG\Post(
     *     path="/doctorFirebaseAndroid",
     *     description="save doctor firebase ID for Android device",
     *     @SWG\Parameter(
     *         name="deviceid",
     *         in="formData",
     *         type="string",
     *         description="Firebase ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *      @SWG\Response(
     *         response=400,
     *         description=""
     *     )
     * )
     */
    public function doctorFirebaseAndroid(Request $request)
    {
        $deviceID = $request->deviceid;
        $doctorID = $request->doctorid;

        $check = Doctor::where("id", $doctorID)->count();

        if ($check == 1) {
            $doctor = Doctor::where("id", $doctorID)->first();

            $doctor->firebase_android = $deviceID;
            $isSaved = $doctor->save();

            if ($isSaved){
                return $this->sendResponse($doctor, 'Saved');
            }else{
                return $this->sendResponse("failed", 'Please try again');
            }
        }
        return $this->sendError("Invalid Doctor ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/doctorFirebaseIOS",
     *     description="save doctor firebase ID for IOS device",
     *     @SWG\Parameter(
     *         name="deviceid",
     *         in="formData",
     *         type="string",
     *         description="Firebase ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *      @SWG\Response(
     *         response=400,
     *         description=""
     *     )
     * )
     */

    public function doctorFirebaseIOS(Request $request)
    {
        $deviceID = $request->deviceid;
        $doctorID = $request->doctorid;

        $check = Doctor::where("id", $doctorID)->count();

        if ($check == 1) {
            $doctor = Doctor::where("id", $doctorID)->first();

            $doctor->firebase_ios = $deviceID;
            $isSaved = $doctor->save();

            if ($isSaved){
                return $this->sendResponse($doctor, 'Saved');
            }else{
                return $this->sendResponse("failed", 'Please try again');
            }
        }
        return $this->sendError("Invalid Doctor ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/doctorPushNotification",
     *     description="Notification for doctor ID",
     *     @SWG\Parameter(
     *         name="deviceid",
     *         in="formData",
     *         type="string",
     *         description="Firebase ID",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *      @SWG\Response(
     *         response=400,
     *         description=""
     *     )
     * )
     */
    public function doctorPushNotification(Request $request)
    {
        $id = $request->deviceid;
        
        $iosCount = Doctor::where("firebase_ios", $id)->count();
        $androidCount = Doctor::where("firebase_android", $id)->count();

        if ($iosCount >= 1){
            $device = Doctor::where("firebase_ios", $id)->first();
            $deviceID = $device->firebase_ios;

            $title = 'A patient needs you!';
            $message = 'Kindly check your dashboard';

            $push = new Push($title, $message, null);
            $mPushNotification = $push->getPush();
            $firebase = new doctorFirebase();

            $response = $firebase->send($deviceID, $mPushNotification, $title, $message);
            
            return Response::json($response);
        }elseif ($androidCount >= 1){

            $device = Doctor::where("firebase_android", $id)->first();
            $deviceID = $device->firebase_android;

            $title = 'A patient needs you!';
            $message = 'Kindly check your dashboard';

            $push = new Push($title, $message, null);
            $mPushNotification = $push->getPush();
            $firebase = new doctorFirebase();

            $response = $firebase->send($deviceID, $mPushNotification, $title, $message);
            
            return Response::json($response);
            
        } else {
            $response = array(
                'status' => false,
                'message' => 'Firebase ID does not exist. Push Notification not sent'
            );
            return Response::json($response);
        }
    }

    /**
     * @SWG\Post(
     *     path="/saveAdminFirebaseIDAndroid",
     *     description="",
     * @SWG\Parameter(
     *         name="admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="deviceid",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function saveAdminFirebaseIDAndroid(Request $request){

        $admin_id = $request->admin_id;
        $deviceid = $request->deviceid;


        $recommendation = \App\HospitalAdmin::where("id", $admin_id)->first();
        $recommendation->firebase_android = $deviceid;
        $recommendation->save();


        return $this->sendResponse("success", 'success');

    }

    /**
     * @SWG\Post(
     *     path="/saveDoctorFirebaseIDAndroid",
     *     description="",
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="deviceid",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function saveDoctorFirebaseIDAndroid(Request $request){

        $doctor_id = $request->doctor_id;
        $deviceid = $request->deviceid;

        $recommendation = \App\Doctor::where("id", $doctor_id)->first();
        $recommendation->firebase_android = $deviceid;
        $recommendation->save();

        return $this->sendResponse("success", 'success');

    }

    /**
     * @SWG\Post(
     *     path="/pushMessageToAdmin",
     *     description="",
     * @SWG\Parameter(
     *         name="admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="devicetype",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="title",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function pushMessageToAdmin(Request $request){

        $admin_id = $request->admin_id;
        $devicetype = $request->devicetype;
        $title = $request->title;
        $body = $request->body;

        $admin = \App\HospitalAdmin::where("id", $admin_id)->first();
        $deviceID = $admin->firebase_android;

        $push = new \App\Push($title, $body, null);
        $mPushNotification = $push->getPush();
        $firebase = new \App\Firebase();

        $response = $firebase->send($deviceID, $mPushNotification, $title, $body);

        return $this->sendResponse("success", 'success');

    }


    /**
     * @SWG\Post(
     *     path="/changeDoctorPassword",
     *     description="",
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="oldpassword",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="newpassword",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function changeDoctorPassword(Request $request){

        $doctor_id = $request->doctor_id;
        $oldpassword = $request->oldpassword;
        $newpassword = $request->newpassword;

        $doctor = \App\Doctor::where("id", $doctor_id)->where("password", $oldpassword)->first();

        if ($doctor != null){
            $doctor->password = $newpassword;
            $doctor->save();
            return $this->sendResponse("success", 'success');
        }else{
            return $this->sendResponse("failed", 'Invalid Old Password');
        }

    }


    /**
     * @SWG\Post(
     *     path="/updateDoctorProfileSettings",
     *     description="",
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="names",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="phonenumber",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="profile",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="specialty",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function updateDoctorProfileSettings(Request $request){

        $doctor_id = $request->doctor_id;
        $names = $request->names;
        $phonenumber = $request->phonenumber;
        $profile = $request->profile;
        $specialty = $request->specialty;

        $doctor = \App\Doctor::where("id", $doctor_id)->first();

        if ($doctor != null){
            $doctor->names = $names;
            $doctor->phone_number = $phonenumber;
            $doctor->profile = $profile;
            $doctor->specialty = $specialty;
            $doctor->save();
            return $this->sendResponse($doctor, 'success');
        }else{
            return $this->sendResponse("failed", 'failed');
        }

    }


    /**
     * @SWG\Post(
     *     path="/getPatientAssignedToDoctor",
     *     description="",
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function getPatientAssignedToDoctor(Request $request){

        $doctor_id = $request->doctor_id;

        $doctor = \App\Patient::where("doctor_id", $doctor_id)->orWhere("assigned_doctor", $doctor_id)->orderby("created_at", "desc")->get();

        return $this->sendResponse($doctor, 'success');

    }

    /**
     * @SWG\Post(
     *     path="/setDoctorAvailability",
     *     description="",
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="status",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function setDoctorAvailability(Request $request){

        $doctor_id = $request->doctor_id;
        $status = $request->status;

        $doctor = \App\Doctor::where("id", $doctor_id)->first();
        $doctor->availability = $status;
        $doctor->save();

        return $this->sendResponse($doctor, 'success');

    }

    /**
     * @SWG\Post(
     *     path="/doctorAvailability",
     *     description="Change availability status as a doctor",
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="availability",
     *         in="formData",
     *         type="number",
     *         description="0 or 1",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function doctorAvailability(Request $request)
    {
        
        $doctorID = $request->doctorid;
        $availability_status = $request->availability;

        $check = Doctor::where('id', $doctorID)->count();

        if($check == 1){
            $doctor = Doctor::where('id', $doctorID)->first();
            $doctor->availability = $availability_status;
            $isSaved = $doctor->save();

            if($isSaved){
                return $this->sendResponse($doctor, 200);
            }
        }
        return $this->sendError('Invalid Doctor ID', 200);
    }



    /**
     * @SWG\Post(
     *     path="/destroyDoctor",
     *     description="Delete doctor info as an admin",
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function deleteDoctor(Request $request)
    {
        $adminID = $request->adminid;
        $doctorID = $request->doctorid;
        $hospitalID = $request->hospitalid;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $checkDoctor = Doctor::where('id', $doctorID)->count();

            if($checkDoctor == 1){
                $doctor = Doctor::where('id', $doctorID)->first();
                $isDeleted = $doctor->delete();

                if($isDeleted){
                    return $this->sendResponse("Doctor deleted Successfully!", 200);
                }else{
                    return $this->sendError("Doctor NOT deleted", null, 200);
                }
            }
            return $this->sendError("Invalid Doctor ID", null, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }


    /**
     * @SWG\Post(
     *     path="/doctorStatus",
     *     description="Disable or Enable doctor as an admin",
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="status",
     *         in="formData",
     *         type="string",
     *         description="enable or disable",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function doctorStatus(Request $request)
    {
        $adminID = $request->adminid;
        $doctorID = $request->doctorid;
        $status = $request->status;
        $hospitalID = $request->hospitalid;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $checkDoctor = Doctor::where('id', $doctorID)->count();

            if($checkDoctor == 1){
                $doctor = Doctor::where('id', $doctorID)->first();
                $doctor->status = $status;
                $isSaved = $doctor->save();

                if($isSaved){
                    return $this->sendResponse($doctor, 200);
                }else{
                    return $this->sendError("Doctor Status NOT updated", null, 200);
                }
            }
            return $this->sendError("Invalid Doctor ID", null, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }
    // **********************************************************Doctor Ends******************************************************

    // **********************************************************General Health Begins******************************************************

    /**
     * @SWG\Post(
     *     path="/addGeneralWardPatientAPI",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="age",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="sex",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="phone_number",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="address",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *  @SWG\Parameter(
     *         name="dob",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="names",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function addGeneralWardPatientAPI(Request $request){

        $hospital_id = $request->hospital_id;
        $doctor_id = $request->doctor_id;
        $patient_id = $request->patient_id;
        $hospital_admin_id = $request->hospital_admin_id;
        $age = $request->age;
        $sex = $request->sex;
        $phone_number = $request->phone_number;
        $address = $request->address;
        $names = $request->names;
        $dob= $request->dob;
       

        
        $count = \App\Patient::where("patient_id", $patient_id)->count();

        if($count == 0){

        $patient = new \App\Patient();
        $patient->hospital_id = $hospital_id;
        $patient->doctor_id = $doctor_id;
        $patient->patient_id = $patient_id;
        $patient->hospital_admin_id = $hospital_admin_id;
        $patient->patient_type_id = 1;
        $patient->age = $age;
        $patient->sex = $sex;
        $patient->names = $names;
        $patient->address = $address;
        $patient->assigned_doctor = $doctor_id;
        $patient->status = 'enable';
        
        if ($request->hasFile("image_path")){
            $destination = "doctor";
            $file = $request->image_path;
            $extension = $file->getClientOriginalExtension();
            $fileName = $names . rand(1111, 9999) . "." . $extension;
            $file->move($destination, $fileName);

            $patient->image_path = $fileName;

        }

        $isSaved = $patient->save();

        if ($isSaved){
       
            return $this->sendResponse($patient, 'Patient created successfully');
        }else{
            return $this->sendResponse("failed", 'Please try again');
        }
    }else{
            return $this->sendResponse("failed", 'Patient id Exist');
        }

    }

      /**
     * @SWG\Post(
     *     path="/getGeneralWardPatient",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function getGeneralWardPatient(Request $request){

        $hospital_id = $request->hospital_id;

        $patient = \App\Patient::where("hospital_id", $hospital_id)->where("patient_type_id", 1)->orderBy("created_at", "desc")->get();

        return $this->sendResponse($patient, 'Patient Retrieved');

    }

    /**
     * @SWG\Post(
     *     path="/getAvailableDoctors",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function getAvailableDoctors(Request $request){

        $doctors = \App\Doctor::where("doctor_type_id", 1)->where("availability", 1)->orderBy("created_at", "desc")->get();

        return $this->sendResponse($doctors, 'Doctors Retrieved');

    }

    /**
     * @SWG\Post(
     *     path="/getGeneralWardPatientHistoryByDate",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="date",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function getGeneralWardPatientHistoryByDate(Request $request){

        $patientID = $request->patient_id;
        $date = $request->date;

        //dd($patientID);

        $data = \App\GeneralHealth::where("patient_id", $patientID)->where("created_at", "like", $date . "%")->orderBy("created_at", "desc")->get();

        return $this->sendResponse($data, 'Retrieved');

    }

    /**
     * @SWG\Post(
     *     path="/getRecommendation",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function getRecommendation(Request $request){

        $patientID = $request->patient_id;

        $data = DB::table('recommendation')
            ->join('doctor', 'doctor_id', '=', 'doctor.id')
            ->select('recommendation.*','doctor.id as doctorid', 'doctor.names', 'doctor.image_path')
            ->where('recommendation.patient_id', '=', $patientID)
            ->orderBy("created_at", "desc")
            ->get();


        return $this->sendResponse($data, 'Retrieved');

    }

    /**
     * @SWG\Post(
     *     path="/addRecommendation",
     *     description="",
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="title",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="body",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="device",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addRecommendation(Request $request){

        $patientID = $request->patient_id;
        $doctor_id = $request->doctor_id;
        $title = $request->title;
        $body = $request->body;
        $device = $request->device;

        //dd ($body);

        $patient = \App\Patient::where("id", $patientID)->first();
        $hospital_admin_id = $patient->hospital_admin_id;

        $hospitalAdmin = \App\HospitalAdmin::where("id", $hospital_admin_id)->first();
        $firebase_android = $hospitalAdmin->firebase_android;

        //dd($firebase_android);

        $push = new \App\Push($title, $body, null);
        $mPushNotification = $push->getPush();
        $firebase = new \App\Firebase();

        $response = $firebase->send($firebase_android, $mPushNotification, $title, $body);

        $recommendation = new \App\Recommendation();
        $recommendation->patient_id = $patientID;
        $recommendation->doctor_id = $doctor_id;
        $recommendation->title = $title;
        $recommendation->body = $body;
        $recommendation->save();


        return $this->sendResponse("success", 'success');

    }

    /**
     * @SWG\Post(
     *     path="/addProforma",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="complaint",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="past_medical_history",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="medical_history",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="drug_allergy",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="social_history",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="established_sign",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="review_of_symptoms",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="general_examination",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="examination_of_relevant_system",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="working_diagnosis",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Parameter(
     *         name="others",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addProforma(Request $request){

        $doctorID = $request->doctor_id;
        $patientID = $request->patient_id;
        $complaint = $request->complaint;
        $past_medical_history = $request->past_medical_history;
        $medical_history = $request->medical_history;
        $drug_allergy = $request->drug_allergy;
        $social_history = $request->social_history;
        $established_sign = $request->established_sign;
        $review_of_symptoms = $request->review_of_symptoms;
        $general_examination = $request->general_examination;
        $examination_of_relevant_system = $request->examination_of_relevant_system;
        $working_diagnosis = $request->working_diagnosis;
        $others = $request->others;

        $amount = $request->amount;
        $hospitalID = $request->hospital_id;
        $channel = $request->channel;
        $hospital_admin_id = $request->hospital_admin_id;


        $proforma = new \App\Proforma();
        $proforma->complaint = $complaint;
        $proforma->past_medical_history = $past_medical_history;
        $proforma->medical_history = $medical_history;
        $proforma->drug_allergy = $drug_allergy;
        $proforma->social_history = $social_history;
        $proforma->established_sign = $established_sign;
        $proforma->review_of_symptoms = $review_of_symptoms;
        $proforma->general_examination = $general_examination;
        $proforma->examination_of_relevant_system = $examination_of_relevant_system;
        $proforma->working_diagnosis = $working_diagnosis;
        $proforma->others = $others;
        $proforma->patient_id = $patientID;
        $proforma->save();

        $patient = \App\Patient::where("id", $patientID)->first();
        $patient->assigned_doctor = $doctorID;

        $patient->save();


        $transaction = new \App\Transaction();
        $transaction->amount = $amount;
        $transaction->channel = $channel;
        $transaction->hospital_id = $hospitalID;
        $transaction->doctor_id = $doctorID;
        $transaction->hospital_admin_id = $hospital_admin_id;
        $transaction->patient_id = $patientID;
        $transaction->save();





        return $this->sendResponse("success", 'success');

    }

    /**
     * @SWG\Post(
     *     path="/getProforma",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function getProforma(Request $request){

        $patientID = $request->patient_id;



        $data = \App\Proforma::where("patient_id", $patientID)->get();

        return $this->sendResponse($data, 'Retrieved');

    }



    /**
     * @SWG\Post(
     *     path="/getTransaction",
     *     description="",
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function getTransaction(Request $request){

        $doctorID = $request->doctor_id;

        $totalAmount = DB::table("transaction")
            ->select(DB::raw("SUM(amount) as amount"))
            ->where("doctor_id", $doctorID)
            ->first();

        $transactions = DB::table('transaction')
            ->join('hospital', 'hospital_id', '=', 'hospital.id')
            ->join('doctor', 'doctor_id', '=', 'doctor.id')
            ->join('hospital_admin', 'hospital_admin_id', '=', 'hospital_admin.id')
            ->select('transaction.*', 'hospital.health_centre_name as name', 'doctor.names as doctorname' , 'hospital_admin.names as adminname')
            ->where("doctor_id", $doctorID)
            ->get();

        $response = [
            'message' => 'success',
            'totalamount'    => $totalAmount,
            'transaction' => $transactions,
        ];
        return Response::json($response, 200 );


    }


    /**
     * @SWG\Post(
     *     path="/getGeneralWardLatestPatientHistory",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function getGeneralWardLatestPatientHistory(Request $request){

        $patientID = $request->patient_id;

        $latest = \App\GeneralHealth::where("patient_id", $patientID)->orderBy("created_at", "desc")->first();


        $createdAt = $latest->created_at;

        //dd($createdAt);

        //$latest = \App\PatientInfoEntity::where("patient_id", $patientID)->orderBy("created_at", "desc")->first();

        $date = date('Y-m-d', strtotime($createdAt));

        $data = \App\GeneralHealth::where("patient_id", $patientID)->where("created_at", "like", $date . "%")->orderBy("created_at", "desc")->get();

        return $this->sendResponse($data, 'Retrieved');

    }

     /**
     * @SWG\Post(
     *     path="/addPatientInfo",
     *     description="",
     * @SWG\Parameter(
     *         name="temperature_value",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="temperature_value_score",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="heart_rate_value",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="heart_rate_value_score",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="diastolic_pressure_score",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="diastolic_pressure_value",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="systolic_pressure_score",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="systolic_pressure_value",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="respiratory_rate_value",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="respiratory_rate_value_score",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="saturation_scale_one_value",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="saturation_scale_one_score",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
      *      @SWG\Parameter(
      *         name="saturation_scale_two_value",
      *         in="formData",
      *         type="number",
      *         description="",
      *         required=true,
      *     ),
      * @SWG\Parameter(
      *         name="saturation_scale_two_score",
      *         in="formData",
      *         type="number",
      *         description="",
      *         required=true,
      *     ),
     * @SWG\Parameter(
     *         name="alertness_value",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="alertness_value_score",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="heart_rate_value",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="heart_rate_value_score",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="is_action_taken",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="action_taken",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addPatientInfo(Request $request){



        $temperature_value = $request->temperature_value;
        $temperature_value_score = $request->temperature_value_score;

        $diastolic_pressure_score = $request->diastolic_pressure_score;
        $diastolic_pressure_value = $request->diastolic_pressure_value;

        $systolic_pressure_score = $request->systolic_pressure_score;
        $systolic_pressure_value = $request->systolic_pressure_value;

        $respiratory_rate_value = $request->respiratory_rate_value;
        $respiratory_rate_value_score = $request->respiratory_rate_value_score;

        $saturation_scale_one_value = $request->saturation_scale_one_value;
        $saturation_scale_one_score = $request->saturation_scale_one_score;

        $saturation_scale_two_value = $request->saturation_scale_two_value;
        $saturation_scale_two_score = $request->saturation_scale_two_score;

        $alertness_value = $request->alertness_value;
        $alertness_value_score = $request->alertness_value_score;

        $heart_rate_value = $request->heart_rate_value;
        $heart_rate_value_score = $request->heart_rate_value_score;

        $is_action_taken = $request->is_action_taken;
        $action_taken = $request->action_taken;


        $hospital_id = $request->hospital_id;
        $hospital_admin_id = $request->hospital_admin_id;
        $patient_id = $request->patient_id;

        $patient = \App\Patient::find($patient_id)->first();
        $doctor_id = $patient->doctor_id;
        $pid = $patient->patient_id;

        $doctor = \App\Doctor::where("id", $doctor_id)->first();
        $firebase_android = $doctor->firebase_android;


        //$patientIdentififcation = $patient->patient_id;
        // $assigned_doctor = $patient->assigned_doctor;
       




        /*$doctor = \App\Doctor::where("id", $assigned_doctor)->first();
        $firebase_android = $doctor->firebase_android;
        $firebase_ios = $doctor->firebase_ios;*/

        
        $patientInfo = new \App\GeneralHealth();
        $patientInfo->respiratory_rate_value = $respiratory_rate_value;
        $patientInfo->respiratory_rate_value_score = $respiratory_rate_value_score;
        $patientInfo->saturation_scale_one_value = $saturation_scale_one_value;
        $patientInfo->saturation_scale_one_score = $saturation_scale_one_score;
        $patientInfo->saturation_scale_two_value = $saturation_scale_two_value;
        $patientInfo->saturation_scale_two_score = $saturation_scale_two_score;
        $patientInfo->alertness_value = $alertness_value;
        $patientInfo->alertness_value_score = $alertness_value_score;
        $patientInfo->temperature_value = $temperature_value;
        $patientInfo->temperature_value_score = $temperature_value_score;
        $patientInfo->heart_rate_value = $heart_rate_value;
        $patientInfo->heart_rate_value_score = $heart_rate_value_score;
        $patientInfo->systolic_pressure_score = $systolic_pressure_score;
        $patientInfo->systolic_pressure_value = $systolic_pressure_value;
        $patientInfo->diastolic_pressure_score = $diastolic_pressure_score;
        $patientInfo->diastolic_pressure_value = $diastolic_pressure_value;
        $patientInfo->is_action_taken = $is_action_taken;
        $patientInfo->action_taken = $action_taken;
        $patientInfo->hospital_id = $hospital_id;
        $patientInfo->hospital_admin_id = $hospital_admin_id;
        $patientInfo->patient_id = $patient_id;

        $isSaved = $patientInfo->save();

        if ($isSaved){

            $message = "Patient: " . $pid . " Update";
            $title = "A new parameter has been added to a patient assigned to you. kindly make recommendation";


            $push = new \App\Push($title, $message, null);
            $mPushNotification = $push->getPush();
            $firebase = new \App\Firebase();

            $response = $firebase->send($firebase_android, $mPushNotification, $title, $message);

            //$this->sendPushToDevice($title, $message, $firebase_android);

            return $this->sendResponse($patientInfo, 'Info Addedd!!');
        }else{
            return $this->sendResponse("failed", 'Please try again');
        }

    }

    /**
     * @SWG\Post(
     *     path="/getLatestPatientInfo",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function getLatestPatientInfo(Request $request){

        $patient_id = $request->patient_id;

        $patientInfo = \App\GeneralHealth::where("patient_id", $patient_id)->orderBy("created_at", "desc")->first();

        return $this->sendResponse($patientInfo, 'Info Retrieved!!');

    }

    /**
     * @SWG\Post(
     *     path="/getPatientInfo",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function getPatientInfo(Request $request){

        $patient_id = $request->patient_id;

        $patientInfo = \App\GeneralHealth::where("patient_id", $patient_id)->get();

        return $this->sendResponse($patientInfo, 'Info Retrieved!!');

    }
    // **********************************************************General Health Begins******************************************************

    // **********************************************************Labour Functionality Begins******************************************************


    /**
     * @SWG\Post(
     *     path="/addLabourComplaint",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="review_status",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="urgency_status",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="request_review",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_to_review",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="impression",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="complaint",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="action_taken",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function labourComplaint(Request $request)
    {
        $adminID = $request->adminid;
        $complaint = $request->complaint;
        $impression = $request->impression;
        $action_taken = $request->action_taken;
        $request_review = $request->request_review;
        $doctor_to_review = $request->doctor_to_review;
        $urgency_status = $request->urgency_status;
        $review_status = $request->review_status;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $patient_type_id = $request->patient_type_id;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $labour = new LabourComplaint();
            $labour->complaint = $complaint;
            $labour->impression = $impression;
            $labour->action_taken = $action_taken;
            $labour->request_review = $request_review;
            $labour->doctor_to_review = $doctor_to_review;
            $labour->urgency_status = $urgency_status;
            $labour->review_status = $review_status;
            $labour->patient_id = $patientID;
            $labour->hospital_id = $hospitalID;
            $labour->doctor_id = $doctorID;
            $labour->patient_type_id = $patient_type_id;
            $labour->hospital_admin_id = $adminID;
            $isSaved = $labour->save();

            if($isSaved){
                return $this->sendResponse($labour, 200);
            }else{
                return $this->sendError("Labour Complaint NOT saved!", null, 200);
            }
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }




    /**
     * @SWG\Post(
     *     path="/editLabourComplaint",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="complaintid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="review_status",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="urgency_status",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="request_review",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_to_review",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="impression",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="complaint",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="action_taken",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function editLabourComplaint(Request $request)
    {
        $adminID = $request->adminid;
        $labour_complaint_id = $request->complaintid;
        $complaint = $request->complaint;
        $impression = $request->impression;
        $action_taken = $request->action_taken;
        $request_review = $request->request_review;
        $doctor_to_review = $request->doctor_to_review;
        $urgency_status = $request->urgency_status;
        $review_status = $request->review_status;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $patient_type_id = $request->patient_type_id;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $complaintCheck = LabourComplaint::where('id', $labour_complaint_id)->count();

            if($complaintCheck){
                $labour = LabourComplaint::where('id', $labour_complaint_id)->first();
                $labour->complaint = $complaint;
                $labour->impression = $impression;
                $labour->action_taken = $action_taken;
                $labour->request_review = $request_review;
                $labour->doctor_to_review = $doctor_to_review;
                $labour->urgency_status = $urgency_status;
                $labour->review_status = $review_status;
                $labour->patient_id = $patientID;
                $labour->hospital_id = $hospitalID;
                $labour->doctor_id = $doctorID;
                $labour->patient_type_id = $patient_type_id;
                $labour->hospital_admin_id = $adminID;
                $isSaved = $labour->save();
                

                if($isSaved){
                    return $this->sendResponse($labour, 200);
                }else{
                    return $this->sendError("Labour Complaint NOT saved!", null, 200);
                }
            }
            return $this->sendError("Invalid Labour Complaint ID", null, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }




    /**
     * @SWG\Post(
     *     path="/showLabourComplaint",
     *     description="",
     * @SWG\Parameter(
     *         name="complaintid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showLabourComplaint(Request $request)
    {
        $labour_complaint_id = $request->complaintid;
        $hospitalID = $request->hospital_id;

        $check = LabourComplaint::where('id', $labour_complaint_id)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $labourComplaint = LabourComplaint::where('id', $labour_complaint_id)->first();

            return $this->sendResponse($labourComplaint, 200);
        }
        return $this->sendError("Invalid Labour Complaint ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/showPatientLabourComplaintRecord",
     *     description="",
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showPatientLabourComplaintRecord(Request $request)
    {
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;

        $check = Hospital::where('id', $hospitalID)->count();
        if($check == 1){
            $checkPatient = LabourComplaint::where('patient_id', $patientID)->count();

            if($checkPatient > 0){
                $patientRecord = LabourComplaint::where('patient_id', $patientID)->latest()->get();

                return $this->sendResponse($patientRecord, 200);
            }
            return $this->sendError("Patient ID NOT found", null, 200);
        }
        return $this->sendError("Invalid Hospital ID", null, 200);
    }

    /**
     * @SWG\Post(
     *     path="/addLabourPlan",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="plan",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="phase",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="responsible_partner",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="employment_status",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="substance_abuse",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="substance_abuse_type",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="smoker",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hiv_status",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addLabourPlan(Request $request)
    {
        $adminID = $request->adminid;
        $plan = $request->plan;
        $phase = $request->phase;
        $responsible_partner = $request->responsible_partner;
        $employment_status = $request->employment_status;
        $substance_abuse = $request->substance_abuse;
        $substance_abuse_type = $request->substance_abuse_type;
        $smoker = $request->smoker;
        $hiv_status = $request->hiv_status;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $patient_type_id = $request->patient_type_id;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            
            $labour = new LabourPlan();
            $labour->plan = $plan;
            $labour->phase = $phase;
            $labour->responsible_partner = $responsible_partner;
            $labour->employment_status = $employment_status;
            $labour->substance_abuse = $substance_abuse;
            $labour->substance_abuse_type = $substance_abuse_type;
            $labour->smoker = $smoker;
            $labour->hiv_status = $hiv_status;
            $labour->patient_id = $patientID;
            $labour->hospital_id = $hospitalID;
            $labour->doctor_id = $doctorID;
            $labour->patient_type_id = $patient_type_id;
            $labour->hospital_admin_id = $adminID;
            $isSaved = $labour->save();
            
            if($isSaved){
                return $this->sendResponse($labour, 200);
            }else{
                return $this->sendError("Labour Plan NOT saved!", null, 200);
            }
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }




    /**
     * @SWG\Post(
     *     path="/editLabourPlan",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="planid",
     *         in="formData",
     *         type="number",
     *         description="Labour Plan ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="plan",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="phase",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="responsible_partner",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="employment_status",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="substance_abuse",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="substance_abuse_type",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="smoker",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hiv_status",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function editLabourPlan(Request $request)
    {
        $adminID = $request->adminid;
        $labourPlanID = $request->planid;
        $plan = $request->plan;
        $phase = $request->phase;
        $responsible_partner = $request->responsible_partner;
        $employment_status = $request->employment_status;
        $substance_abuse = $request->substance_abuse;
        $substance_abuse_type = $request->substance_abuse_type;
        $smoker = $request->smoker;
        $hiv_status = $request->hiv_status;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $patient_type_id = $request->patient_type_id;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $checkPlan = LabourPlan::where('id', $labourPlanID)->count();

            if($checkPlan == 1){
                $labour = LabourPlan::where('id', $labourPlanID)->first();
                $labour->plan = $plan;
                $labour->phase = $phase;
                $labour->responsible_partner = $responsible_partner;
                $labour->employment_status = $employment_status;
                $labour->substance_abuse = $substance_abuse;
                $labour->substance_abuse_type = $substance_abuse_type;
                $labour->smoker = $smoker;
                $labour->hiv_status = $hiv_status;
                $labour->patient_id = $patientID;
                $labour->hospital_id = $hospitalID;
                $labour->doctor_id = $doctorID;
                $labour->patient_type_id = $patient_type_id;
                $labour->hospital_admin_id = $adminID;
                $isSaved = $labour->save();
                
                if($isSaved){
                    return $this->sendResponse($labour, 200);
                }else{
                    return $this->sendError("Labour Plan NOT saved!", null, 200);
                }
            }
            return $this->sendError("Invalid Labour Plan ID", null, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/showLabourPlan",
     *     description="",
     * @SWG\Parameter(
     *         name="planid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showLabourPlan(Request $request)
    {
        $labour_plan_id = $request->planid;
        $hospitalID = $request->hospitalid;

        $check = LabourPlan::where('id', $labour_plan_id)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $plan = LabourPlan::where('id', $labour_plan_id)->where('hospital_id', $hospitalID)->first();

            return $this->sendResponse($plan, 200);
        }
        return $this->sendError('Invalid Labour Plan or Hospital ID', null, 200);
    }


    /**
     * @SWG\Post(
     *     path="/destroyLabourPlan",
     *     description="",
     * @SWG\Parameter(
     *         name="planid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function deleteLabourPlan(Request $request)
    {
        $labour_plan_id = $request->planid;
        $hospitalID = $request->hospitalid;

        $check = LabourPlan::where('id', $labour_plan_id)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $plan = LabourPlan::where('id', $labour_plan_id)->where('hospital_id', $hospitalID)->first();
            $isDeleted = $plan->delete();

            if($isDeleted){
                return $this->sendResponse("Labour Plan deleted successfully!", 200);
            }else{
                return $this->sendResponse("Labour Plan NOT deleted!", null, 200);
            }
        }
        return $this->sendError('Invalid Labour Plan or Hospital ID', null, 200);
    }





    /**
     * @SWG\Post(
     *     path="/showPatientLabourPlanRecord",
     *     description="",
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showPatientLabourPlanRecord(Request $request)
    {
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;

        $check = Hospital::where('id', $hospitalID)->count();
        if($check == 1){
            $checkPatient = LabourPlan::where('patient_id', $patientID)->count();

            if($checkPatient > 0){
                $patientRecord = LabourPlan::where('patient_id', $patientID)->latest()->get();

                return $this->sendResponse($patientRecord, 200);
            }
            return $this->sendError("Patient ID NOT found", null, 200);
        }
        return $this->sendError("Invalid Hospital ID", null, 200);
    }

    /**
     * @SWG\Post(
     *     path="/addLabourCategory",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="deliverymode",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="riskstatus",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function addLabourCategory(Request $request)
    {
        $riskStatus = $request->riskstatus;
        $deliveryMode = $request->deliverymode;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $adminID = $request->adminid;
        $patientTypeID = $request->patient_type_id;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $labour = new LabourCategory();
            $labour->risk_status = $riskStatus;
            $labour->mode_of_delivery = $deliveryMode;
            $labour->patient_id = $patientID;
            $labour->hospital_id = $hospitalID;
            $labour->doctor_id = $doctorID;
            $labour->hospital_admin_id = $adminID;
            $labour->patient_type_id = $patientTypeID;
            $isSaved = $labour->save();

            if($isSaved){
                return $this->sendResponse($labour, 200);
            }else{
                return $this->sendError("Labour Category NOT saved!", null, 200);
            }
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/editLabourCategory",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="categoryid",
     *         in="formData",
     *         type="number",
     *         description="Labour Plan ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="deliverymode",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="riskstatus",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function editLabourCategory(Request $request)
    {
        $riskStatus = $request->riskstatus;
        $deliveryMode = $request->deliverymode;
        $categoryID = $request->categoryid;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $adminID = $request->adminid;
        $patientTypeID = $request->patient_type_id;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $checkCategory = LabourCategory::where('id', $categoryID)->count();

            if($checkCategory == 1){
                $labour = LabourCategory::where('id', $categoryID)->first();
                $labour->risk_status = $riskStatus;
                $labour->mode_of_delivery = $deliveryMode;
                $labour->patient_id = $patientID;
                $labour->hospital_id = $hospitalID;
                $labour->doctor_id = $doctorID;
                $labour->hospital_admin_id = $adminID;
                $labour->patient_type_id = $patientTypeID;
                $isSaved = $labour->save();

                if($isSaved){
                    return $this->sendResponse($labour, 200);
                }else{
                    return $this->sendError("Labour Category NOT saved!", null, 200);
                }
            }
            return $this->sendError("Invalid Labour Category ID", null, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/showLabourCategory",
     *     description="",
     * @SWG\Parameter(
     *         name="categoryid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showLabourCategory(Request $request)
    {
        $categoryID = $request->categoryid;
        $hospitalID = $request->hospitalid;

        $check = LabourCategory::where('id', $categoryID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $category = LabourCategory::where('id', $categoryID)->where('hospital_id', $hospitalID)->first();

            return $this->sendResponse($category, 200);
        }
        return $this->sendError('Invalid Labour Category or Hospital ID', null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/destroyLabourCategory",
     *     description="",
     * @SWG\Parameter(
     *         name="categoryid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function deleteLabourCategory(Request $request)
    {
        $categoryID = $request->categoryid;
        $hospitalID = $request->hospitalid;

        $check = LabourCategory::where('id', $categoryID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $category = LabourCategory::where('id', $categoryID)->where('hospital_id', $hospitalID)->first();
            $isDeleted = $category->delete();

            if($isDeleted){
                return $this->sendResponse("Labour Category deleted successfully!", 200);
            }else{
                return $this->sendError('Labour Category NOT deleted', null, 200);
            }
        }
        return $this->sendError('Invalid Labour Category or Hospital ID', null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/addLabourVaginalExamination",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="remark",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="pelvic_assess",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="celvicdilation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="impression",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="plan",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function addLabourVaginalExam(Request $request)
    {
        $remark = $request->remark;
        $pelvic_assess = $request->pelvic_assess;
        $cervical_dilation = $request->cervicaldilation;
        $impression =$request->impression;
        $plan = $request->plan;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $adminID = $request->adminid;
        $patientTypeID = $request->patient_type_id;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $labour = new LabourVaginalExamination();
            $labour->remark = $remark;
            $labour->pelvic_assess_req = $pelvic_assess;
            $labour->cervical_dilation = $cervical_dilation;
            $labour->impression = $impression;
            $labour->plan = $plan;
            $labour->patient_id = $patientID;
            $labour->hospital_id = $hospitalID;
            $labour->doctor_id = $doctorID;
            $labour->hospital_admin_id = $adminID;
            $labour->patient_type_id = $patientTypeID;
            $isSaved = $labour->save();

            if($isSaved){
                return $this->sendResponse($labour, 200);
            }else{
                return $this->sendError("Labour Category NOT saved!", null, 200);
            }
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/editLabourVaginalExamination",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_type_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="examid",
     *         in="formData",
     *         type="number",
     *         description="Vaginal examination ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="remark",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="pelvic_assess",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="celvicdilation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="impression",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="plan",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function editLabourVaginalExam(Request $request)
    {
        $remark = $request->remark;
        $pelvic_assess = $request->pelvic_assess;
        $cervical_dilation = $request->cervicaldilation;
        $impression =$request->impression;
        $plan = $request->plan;
        $examID = $request->examid;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $adminID = $request->adminid;
        $patientTypeID = $request->patient_type_id;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $checkExamID = LabourVaginalExamination::where('id', $examID)->count();

            if($checkExamID == 1){
                $labour = LabourVaginalExamination::where('id', $examID)->first();
                $labour->remark = $remark;
                $labour->pelvic_assess_req = $pelvic_assess;
                $labour->cervical_dilation = $cervical_dilation;
                $labour->impression = $impression;
                $labour->plan = $plan;
                $labour->patient_id = $patientID;
                $labour->hospital_id = $hospitalID;
                $labour->doctor_id = $doctorID;
                $labour->hospital_admin_id = $adminID;
                $labour->patient_type_id = $patientTypeID;
                $isSaved = $labour->save();

                if($isSaved){
                    return $this->sendResponse($labour, 200);
                }else{
                    return $this->sendError("Labour Vaginal Examination NOT saved!", null, 200);
                }
            }
            return $this->sendError("Invalid Labour Vaginal Examination ID", null, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }


    /**
     * @SWG\Post(
     *     path="/showLabourVaginalExam",
     *     description="",
     * @SWG\Parameter(
     *         name="examid",
     *         in="formData",
     *         type="number",
     *         description="Vaginal examination ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showLabourVaginalExam(Request $request)
    {
        $examID = $request->examid;
        $hospitalID = $request->hospitalid;

        $check = LabourVaginalExamination::where('id', $examID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $examination = LabourVaginalExamination::where('id', $examID)->where('hospital_id', $hospitalID)->first();

            return $this->sendResponse($examination, 200);
        }
        return $this->sendError('Invalid Labour Category or Hospital ID', null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/destroyLabourVaginalExam",
     *     description="",
     * @SWG\Parameter(
     *         name="examid",
     *         in="formData",
     *         type="number",
     *         description="Vaginal examination ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function deleteLabourVaginalExam(Request $request)
    {
        $examID = $request->examid;
        $hospitalID = $request->hospitalid;

        $check = LabourVaginalExamination::where('id', $examID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $vaginalExamination = LabourVaginalExamination::where('id', $examID)->where('hospital_id', $hospitalID)->first();
            $isDeleted = $vaginalExamination->delete();

            if($isDeleted){
                return $this->sendResponse("Labour Vaginal Examination deleted successfully!", 200);
            }else{
                return $this->sendError('Labour Vaginal Examination NOT deleted', null, 200);
            }
        }
        return $this->sendError('Invalid Labour Vaginal Examination or Hospital ID', null, 200);
    }


    /**
     * @SWG\Post(
     *     path="/showPatientLabourVaginalExamRecord",
     *     description="Show all records for specific patient",
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showPatientLabourVaginalExamRecord(Request $request)
    {
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;

        $check = Hospital::where('id', $hospitalID)->count();
        if($check == 1){
            $checkPatient = LabourVaginalExamination::where('patient_id', $patientID)->count();

            if($checkPatient > 0){
                $patientRecord = LabourVaginalExamination::where('patient_id', $patientID)->latest()->get();

                return $this->sendResponse($patientRecord, 200);
            }
            return $this->sendError("Patient ID NOT found", null, 200);
        }
        return $this->sendError("Invalid Hospital ID", null, 200);
    }
    // **********************************************************Labour Functionality Ends******************************************************


    // **********************************************************Labour Partograph Begins******************************************************



    /**
     * @SWG\Post(
     *     path="/addLabourPartograph",
     *     description="",
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="fetal",
     *         in="formData",
     *         type="number",
     *         description="heart rate",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="cervix",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="descent",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="liquor",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="moulding",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="contraction",
     *         in="formData",
     *         type="number",
     *         description="contraction per 10 mins",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="oxytocin",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="ul",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="drops",
     *         in="formData",
     *         type="number",
     *         description="drops per min",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="systolic",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="diastolic",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="temperature",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="heartrate",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="urine",
     *         in="formData",
     *         type="number",
     *         description="urine amount",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="protein",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="acetone",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="assessment",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="actions",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="recommendation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="next_assessment",
     *         in="formData",
     *         type="string",
     *         description="date with timezone",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function addLabourPartograph(Request $request)
    {
        $fetal = $request->fetal_heart_rate;
        $cervix = $request->cervix;
        $descent = $request->descent;
        $liquor = $request->liquor;
        $moulding = $request->moulding;
        $contraction = $request->contraction;
        $oxytocin = $request->oxytocin;
        $ul = $request->ul;
        $drops = $request->drops;
        $systolic = $request->systolic;
        $diastolic = $request->diastolic;
        $temperature = $request->temperature;
        $heartrate = $request->heartrate;
        $urine_amount = $request->urine;
        $protein = $request->protein;
        $acetone = $request->acetone;
        $assessment = $request->assessment;
        $actions = $request->actions;
        $recommendation = $request->recommendation;
        $next_assessment = $request->next_assessment;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $adminID = $request->adminid;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();
        $checkDoctor = HospitalDoctor::where('doctor_id', $doctorID)->where('hospital_id', $hospitalID)->count();

        if(($checkAdmin == 1) && ($checkDoctor == 1)){
            $partograph = new LabourPartograph();
            $partograph->fetal_heart_rate = $fetal;
            $partograph->cervix = $cervix;
            $partograph->descent = $descent;
            $partograph->liquor = $liquor;
            $partograph->moulding = $moulding;
            $partograph->contraction_per_10_min = $contraction;
            $partograph->oxytocin = $oxytocin;
            $partograph->ul = $ul;
            $partograph->drops_per_min = $drops;
            $partograph->systolic = $systolic;
            $partograph->diastolic = $diastolic;
            $partograph->temperature = $temperature;
            $partograph->heartrate = $heartrate;
            $partograph->urine_amount = $urine_amount;
            $partograph->protein = $protein;
            $partograph->acetone = $acetone;
            $partograph->assessment = $assessment;
            $partograph->actions = $actions;
            $partograph->recommendation = $recommendation;
            $partograph->next_assessment = $next_assessment;
            $partograph->patient_id = $patientID;
            $partograph->hospital_id = $hospitalID;
            $partograph->doctor_id = $doctorID;
            $partograph->hospital_admin_id = $adminID;
            $isSaved = $partograph->save();

            if($isSaved){
                return $this->sendResponse($partograph, 200);
            }else{
                return $this->sendError('Partograph NOT saved!', null, 200);
            }
        }
        return $this->sendError("Invalid Hospital, Admin or Doctor ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/editLabourPartograph",
     *     description="",
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="partographid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="fetal",
     *         in="formData",
     *         type="number",
     *         description="heart rate",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="cervix",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="descent",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="liquor",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="moulding",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="contraction",
     *         in="formData",
     *         type="number",
     *         description="contraction per 10 mins",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="oxytocin",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="ul",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="drops",
     *         in="formData",
     *         type="number",
     *         description="drops per min",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="systolic",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="diastolic",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="temperature",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="heartrate",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="urine",
     *         in="formData",
     *         type="number",
     *         description="urine amount",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="protein",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="acetone",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="assessment",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="actions",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="recommendation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="next_assessment",
     *         in="formData",
     *         type="string",
     *         description="date with timezone",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function editLabourPartograph(Request $request)
    {
        $fetal = $request->fetal_heart_rate;
        $cervix = $request->cervix;
        $descent = $request->descent;
        $liquor = $request->liquor;
        $moulding = $request->moulding;
        $contraction = $request->contraction;
        $oxytocin = $request->oxytocin;
        $ul = $request->ul;
        $drops = $request->drops;
        $systolic = $request->systolic;
        $diastolic = $request->diastolic;
        $temperature = $request->temperature;
        $heartrate = $request->heartrate;
        $urine_amount = $request->urine;
        $protein = $request->protein;
        $acetone = $request->acetone;
        $assessment = $request->assessment;
        $actions = $request->actions;
        $recommendation = $request->recommendation;
        $next_assessment = $request->next_assessment;
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;
        $doctorID = $request->doctorid;
        $adminID = $request->adminid;
        $partographID = $request->partographid;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();
        $checkDoctor = HospitalDoctor::where('doctor_id', $doctorID)->where('hospital_id', $hospitalID)->count();

        if(($checkAdmin == 1) && ($checkDoctor == 1)){
            $checkPartograph = LabourPartograph::where('id', $partographID)->count();

            if($checkPartograph == 1){
                $partograph = LabourPartograph::where('id', $partographID)->first();
                $partograph->fetal_heart_rate = $fetal;
                $partograph->cervix = $cervix;
                $partograph->descent = $descent;
                $partograph->liquor = $liquor;
                $partograph->moulding = $moulding;
                $partograph->contraction_per_10_min = $contraction;
                $partograph->oxytocin = $oxytocin;
                $partograph->ul = $ul;
                $partograph->drops_per_min = $drops;
                $partograph->systolic = $systolic;
                $partograph->diastolic = $diastolic;
                $partograph->temperature = $temperature;
                $partograph->heartrate = $heartrate;
                $partograph->urine_amount = $urine_amount;
                $partograph->protein = $protein;
                $partograph->acetone = $acetone;
                $partograph->assessment = $assessment;
                $partograph->actions = $actions;
                $partograph->recommendation = $recommendation;
                $partograph->next_assessment = $next_assessment;
                $partograph->patient_id = $patientID;
                $partograph->hospital_id = $hospitalID;
                $partograph->doctor_id = $doctorID;
                $partograph->hospital_admin_id = $adminID;
                $isSaved = $partograph->save();

                if($isSaved){
                    return $this->sendResponse($partograph, 200);
                }else{
                    return $this->sendError('Partograph NOT updated!', null, 200);
                }
            }
            return $this->sendError('Invalid Partograph ID!', null, 200);
        }
        return $this->sendError("Invalid Hospital, Admin or Doctor ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/showLabourPartograph",
     *     description="view partograph",
     * @SWG\Parameter(
     *         name="partographid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showLabourPartograph(Request $request)
    {
        $partographID = $request->partographid;
        $hospitalID = $request->hospitalid;

        $check = LabourPartograph::where('id', $partographID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $partograph = LabourPartograph::where('id', $partographID)->where('hospital_id', $hospitalID)->first();

            return $this->sendResponse($partograph, 200);
        }
        return $this->sendError("Invalid Hospital or partograph ID", null, 200);
    }




    /**
     * @SWG\Post(
     *     path="/destroyLabourPartograph",
     *     description="delete partograph",
     * @SWG\Parameter(
     *         name="partographid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function deleteLabourPartograph(Request $request)
    {
        $partographID = $request->partographid;
        $hospitalID = $request->hospitalid;

        $check = LabourPartograph::where('id', $partographID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $partograph = LabourPartograph::where('id', $partographID)->where('hospital_id', $hospitalID)->first();
            $isDeleted = $partograph->delete();

            if($isDeleted){
                return $this->sendResponse("Partograph deleted successfully!", 200);
            }else {
                return $this->sendError("Partograph NOT deleted!", 200);
            }
        }
        return $this->sendError("Invalid Hospital or partograph ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/allLabourPartograph",
     *     description="get all partograph",
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function allLabourPartograph(Request $request)
    {
        $adminID = $request->adminid;
        $hospitalID = $request->hospitalid;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $partograph = LabourPartograph::where('hospital_id', $hospitalID)->get();

            return $this->sendResponse($partograph, 200);
        }
        return $this->sendError("Invalid Hospital or partograph ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/patientLabourPartograph",
     *     description="get all partograph belonging to single patient",
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function patientLabourPartograph(Request $request)
    {
        $patientID = $request->patientid;
        $hospitalID = $request->hospitalid;

        $check = LabourPartograph::where('patient_id', $patientID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $partograph = LabourPartograph::where('patient_id', $patientID)->where('hospital_id', $hospitalID)->get();

            return $this->sendResponse($partograph, 200);
        }
        return $this->sendError("Invalid Hospital or patient ID", null, 200);
    }


    // **********************************************************Deliverance Summary Begins******************************************************



    /**
     * @SWG\Post(
     *     path="/addDeliverySummary",
     *     description="",
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="delivery_time",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="g_a",
     *         in="formData",
     *         type="number",
     *         description="Gestation age",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="parity",
     *         in="formData",
     *         type="number",
     *         description="number of children previously birthed",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="delivery_mode",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="augmentation",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="baby_status",
     *         in="formData",
     *         type="number",
     *         description="contraction per 10 mins",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="sex",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="apgar_1_min",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="apgar_5_min",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="apgar_10_min",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="apgar_20_min",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="resuscitation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="weight",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="placenta",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="manual_evacution",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="bloodloss_estimate",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="bp",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hr",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="referral_required",
     *         in="formData",
     *         type="string",
     *         description="0 or 1/ true or false",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="fluid_resuscitation",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="blood_transfer",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="anti_shock",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="cpr",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="oxytocin",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="misoprostol",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="uterine",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="tamponade",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="other_intervention",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="bloodloss_source",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="arrest_bleeding",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="bleeding_referral",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_risk",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_risk_intervention",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_final_action",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_final_action",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addDeliverySummary(Request $request)
    {
        $all = $request->all();
        
        $checkAdmin = HospitalAdmin::where('id', $all['hospital_admin_id'])->where('hospital_id', $all['hospital_id'])->count();
        $checkDoctor = HospitalDoctor::where('doctor_id', $all['doctor_id'])->where('hospital_id', $all['hospital_id'])->count();

        if(($checkAdmin == 1) && ($checkDoctor == 1)){
            $deliverySummary = DeliverySummary::create(Input::all());

            if($deliverySummary){
                return $this->sendResponse($deliverySummary, 200);
            }
            
        }
        return $this->sendError('Invalid Hospital, Admin or Doctor ID', null, 200);
    }





    /**
     * @SWG\Post(
     *     path="/editDeliverySummary",
     *     description="",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="delivery Summary id",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="delivery_time",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="g_a",
     *         in="formData",
     *         type="number",
     *         description="Gestation age",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="parity",
     *         in="formData",
     *         type="number",
     *         description="number of children previously birthed",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="delivery_mode",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="augmentation",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="baby_status",
     *         in="formData",
     *         type="number",
     *         description="contraction per 10 mins",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="sex",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="apgar_1_min",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="apgar_5_min",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="apgar_10_min",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="apgar_20_min",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="resuscitation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         name="weight",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="placenta",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="manual_evacution",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="bloodloss_estimate",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="bp",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="hr",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="referral_required",
     *         in="formData",
     *         type="string",
     *         description="0 or 1/ true or false",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="fluid_resuscitation",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="blood_transfer",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="anti_shock",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="cpr",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="oxytocin",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="misoprostol",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="uterine",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="tamponade",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="other_intervention",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="bloodloss_source",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="arrest_bleeding",
     *         in="formData",
     *         type="string",
     *         description="0 or 1",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="bleeding_referral",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_risk",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_risk_intervention",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_final_action",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_final_action",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * 
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function editDeliverySummary(Request $request)
    {
        $all = $request->all();

        $checkAdmin = HospitalAdmin::where('id', $all['hospital_admin_id'])->where('hospital_id', $all['hospital_id'])->exists();
        $checkDoctor = DeliverySummary::where('doctor_id', $all['doctor_id'])->where('hospital_id', $all['hospital_id'])->exists();
        
        if(($checkAdmin) && ($checkDoctor)){
            $checkSummary = DeliverySummary::where('id', $all['id'])->count();

            if($checkSummary == 1){
                $newdeliverySummary = DeliverySummary::where('id', $all['id'])->update(Input::all());
                $deliverySummary = DeliverySummary::where('id', $all['id'])->get();
                
                if($newdeliverySummary){
                    return $this->sendResponse($deliverySummary, 200);
                }
            }
            return $this->sendError('Invalid Delivery Summary ID', null, 200);
        }
        return $this->sendError('Invalid Hospital, Admin or Doctor ID', null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/showDeliverySummary",
     *     description="view delivery summary",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="Delivery Summary ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function showDeliverySummary(Request $request)
    {
        $all = $request->all();

        $checkSummary = DeliverySummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->exists();
        $summary = DeliverySummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->first();
        return $checkSummary ? $this->sendResponse($summary, 200) :  $this->sendError('Invalid Hospital, Admin or Doctor ID', null, 200);
        // if($checkSummary){
        //     $summary = DeliverySummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->first();

        //     return $this->sendResponse($summary, 200);
        // }
        // return $this->sendError("Invalid Hospital or Delivery Summary ID", null, 200);
        
    }



    /**
     * @SWG\Post(
     *     path="/destroyDeliverySummary",
     *     description="delete delivery summary info",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="Delivery Summary ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function deleteDeliverySummary(Request $request)
    {
        $all = $request->all();

        $checkSummary = DeliverySummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->exists();
        $summary = DeliverySummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->delete();

        return $checkSummary ? $this->sendResponse("Delivery Summary Info Deleted!", 200) :  $this->sendError('Invalid Hospital or Delivery Summary ID', null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/allDeliverySummary",
     *     description="get all delivery summary as Admin",
     * @SWG\Parameter(
     *         name="admin_id",
     *         in="formData",
     *         type="number",
     *         description="Admin ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function allDeliverySummary(Request $request)
    {
        $all = $request->all();

        $checkAdmin = HospitalAdmin::where('id', $all['admin_id'])->exists();

        $allDeliverySummary = DeliverySummary::where('hospital_id', $all['hospital_id'])->get();
        return $checkAdmin ? $this->sendResponse($allDeliverySummary, 200) :  $this->sendError('Invalid Hospital or Admin ID', null, 200);
    }


    // **********************************************************Discharge Summary Records Begins******************************************************



    /**
     * @SWG\Post(
     *     path="/addDischargeSummary",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="Admin ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="mother_bp",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_hr",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_temperature",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_respiration",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_saturation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_bp",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_saturation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_hr",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_respiration",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_temperature",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="next_appointment",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addDischargeSummary(Request $request)
    {
        $all = $request->all();

        $checkAdmin = HospitalAdmin::where('id', $all['hospital_admin_id'])->where('hospital_id', $all['hospital_id'])->exists();
        $checkDoctor = HospitalDoctor::where('doctor_id', $all['doctor_id'])->where('hospital_id', $all['hospital_id'])->exists();

        if($checkAdmin && $checkDoctor){
            $dischargeSummary = DischargeSummary::create(Input::all());

            return $this->sendResponse($dischargeSummary, 200);
        }
        
        return $this->sendError("Invalid Hospital, Admin or Doctor ID", null, 200);
    }




    /**
     * @SWG\Post(
     *     path="/editDischargeSummary",
     *     description="",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="Discharge Summary ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="Admin ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="mother_bp",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_hr",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_temperature",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_respiration",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="mother_saturation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_bp",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_saturation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_hr",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_respiration",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="baby_temperature",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="next_appointment",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function editDischargeSummary(Request $request)
    {
        $all = $request->all();

        $checkAdmin = HospitalAdmin::where('id', $all['hospital_admin_id'])->where('hospital_id', $all['hospital_id'])->exists();
        $checkDoctor = DischargeSummary::where('doctor_id', $all['doctor_id'])->where('hospital_id', $all['hospital_id'])->exists();

        if($checkAdmin && $checkDoctor){
            $checkSummary = DischargeSummary::where('id', $all['id'])->exists();
            if($checkSummary){
                $updateSummary = DischargeSummary::where('id', $all['id'])->update(Input::all());
                $summary = DischargeSummary::find($all['id']);

                return $this->sendResponse($summary, 200);
            }
            return $this->sendError("Invalid Discharge ID", null, 200);
        }
        return $this->sendError("Invalid Hospital, Admin or Doctor ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/showDischargeSummary",
     *     description="",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="Discharge Summary ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    
    public function showDischargeSummary(Request $request)
    {
        $all = $request->all();

        $checkSummary = DischargeSummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->exists();
        $summary = DischargeSummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->first();
        return $checkSummary ? $this->sendResponse($summary, 200) :  $this->sendError('Invalid Hospital, Admin or Doctor ID', null, 200);
    }

    /**
     * @SWG\Post(
     *     path="/destroyDischargeSummary",
     *     description="",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="Discharge Summary ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function deleteDischargeSummary(Request $request)
    {
        $all = $request->all();

        $checkSummary = DischargeSummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->exists();
        
        if($checkSummary){
            $summary = DischargeSummary::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->delete();

            return $this->sendResponse("Discharge Summary Info Deleted!", 200);
        }
        
        return $this->sendError('Invalid Hospital or Discharge Summary ID', null, 200);
    }


    /**
     * @SWG\Post(
     *     path="/allDischargeSummary",
     *     description="get all delivery summary as Admin",
     * @SWG\Parameter(
     *         name="admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function allDischargeSummary(Request $request)
    {
        $all = $request->all();

        $checkAdmin = HospitalAdmin::where('id', $all['admin_id'])->exists();
        if($checkAdmin){
            $allDischargeSummary = DischargeSummary::where('hospital_id', $all['hospital_id'])->get();

            return $this->sendResponse($allDischargeSummary, 200);
        }
        return $this->sendError('Invalid Hospital or Admin ID', null, 200);
    }

    // **********************************************************Discharge Summary Records Begins******************************************************



    /**
     * @SWG\Post(
     *     path="/addLabourAssessment",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="Admin ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="bp",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="heart_rate",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="temperature",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="respiration",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="o2_saturation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="symphisotudal_height",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="lie",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="presentation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="position",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="descent",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="fetal_heart_rate",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addLabourAssessment(Request $request)
    {
        $all = $request->all();

        $checkAdmin = HospitalAdmin::where('id', $all['hospital_admin_id'])->where('hospital_id', $all['hospital_id'])->exists();
        $checkDoctor = HospitalDoctor::where('doctor_id', $all['doctor_id'])->where('hospital_id', $all['hospital_id'])->exists();

        if($checkAdmin && $checkDoctor){
            $labourAssessment = LabourAssessment::create(Input::all());

            return $this->sendResponse($labourAssessment, 200);
        }
        
        return $this->sendError("Invalid Hospital, Admin or Doctor ID", null, 200);
    }




    /**
     * @SWG\Post(
     *     path="/editLabourAssessment",
     *     description="",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="Labour assessment ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="Admin ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="bp",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="heart_rate",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="temperature",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="respiration",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="o2_saturation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="symphisotudal_height",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="lie",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="presentation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="position",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="descent",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="fetal_heart_rate",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function editLabourAssessment(Request $request)
    {
        $all = $request->all();

        $checkAdmin = HospitalAdmin::where('id', $all['hospital_admin_id'])->where('hospital_id', $all['hospital_id'])->exists();
        $checkDoctor = LabourAssessment::where('doctor_id', $all['doctor_id'])->where('hospital_id', $all['hospital_id'])->exists();

        if($checkAdmin && $checkDoctor){
            $checkAssessment = LabourAssessment::where('id', $all['id'])->exists();
            if($checkAssessment){
                $updateAssessment = LabourAssessment::where('id', $all['id'])->update(Input::all());
                $assessment = LabourAssessment::find($all['id']);

                return $this->sendResponse($assessment, 200);
            }
            return $this->sendError("Invalid Labour Assessment ID", null, 200);
        }
        return $this->sendError("Invalid Hospital, Admin or Doctor ID", null, 200);
    }




    /**
     * @SWG\Post(
     *     path="/showLabourAssessment",
     *     description="",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="Labour assessment ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showLabourAssessment(Request $request)
    {
        $all = $request->all();

        $checkAssessment = LabourAssessment::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->exists();

        if($checkAssessment){
            $assessment = LabourAssessment::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->first();
            return $this->sendResponse($assessment, 200);
        }
        
        return $this->sendError('Invalid Hospital, Admin or Doctor ID', null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/destroyLabourAssessment",
     *     description="",
     * @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         type="number",
     *         description="Labour assessment ID",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function deleteLabourAssessment(Request $request)
    {
        $all = $request->all();

        $checkAssessment = LabourAssessment::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->exists();
        
        if($checkAssessment){
            $summary = LabourAssessment::where('id', $all['id'])->where('hospital_id', $all['hospital_id'])->delete();

            return $this->sendResponse("Labour Assessment Info Deleted!", 200);
        }
        
        return $this->sendError('Invalid Hospital or Labour Assessment ID', null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/allLabourAssessment",
     *     description="get all labour assessment as Admin",
     * @SWG\Parameter(
     *         name="admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function allLabourAssessment(Request $request)
    {
        $all = $request->all();

        $checkAdmin = HospitalAdmin::where('id', $all['admin_id'])->exists();
        if($checkAdmin){
            $allLabourAssessment = LabourAssessment::where('hospital_id', $all['hospital_id'])->get();

            return $this->sendResponse($allLabourAssessment, 200);
        }
        return $this->sendError('Invalid Hospital or Admin ID', null, 200);
    }
    // **********************************************************Medical Records Begins******************************************************

    /**
     * @SWG\Post(
     *     path="/addMedicalHistory",
     *     description="add medical history for specific patient",
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patienttypeid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="hypertension",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="previous_hyper_in_preg",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="diabetes_mellitus",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="previous_dm_in_preg",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="heart_disease",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="pre_eclampsia",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="still_birth",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="post_partum_haemorrhage",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="ante_partum_haemorrhage",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="two_more_miscarriages",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="h_macrosomia_45kg",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="h_low_birth_weight",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="h_birth_defects",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="history_of_clot",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="myomectomy",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="previous_c_s",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="number_of_c_s",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="epileptic",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="asthmatic",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function addMedicalHistory(Request $request)
    {
        $hospitalID = $request->hospitalid;
        $adminID = $request->adminid;
        $doctorID = $request->doctorid;
        $patientTypeID = $request->patienttypeid;
        $patientID = $request->patientid;
        $hypertension = $request->hypertension;
        $previous_hyper_in_preg = $request->previous_hyper_in_preg;
        $diabetes_mellitus = $request->diabetes_mellitus;
        $previous_dm_in_preg = $request->previous_dm_in_preg;
        $heart_disease = $request->heart_disease;
        $pre_eclampsia = $request->pre_eclampsia;
        $still_birth = $request->still_birth;
        $post_partum_haemorrhage = $request->post_partum_haemorrhage;
        $ante_partum_haemorrhage = $request->ante_partum_haemorrhage;
        $two_more_miscarriages = $request->two_more_miscarriages;
        $h_macrosomia_45kg = $request->h_macrosomia_45kg;
        $h_low_birth_weight = $request->h_low_birth_weight;
        $h_birth_defects = $request->h_birth_defects;
        $history_of_clot = $request->history_of_clot;
        $myomectomy = $request->myomectomy;
        $previous_c_s = $request->previous_c_s;
        $number_of_c_s = $request->number_of_c_s;
        $epileptic = $request->epileptic;
        $asthmatic = $request->asthmatic;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $medical = new MedicalHistory();
            $medical->$hypertension = $hypertension;
            $medical->previous_hyper_in_preg = $previous_hyper_in_preg;
            $medical->diabetes_mellitus = $diabetes_mellitus;
            $medical->previous_dm_in_preg = $previous_dm_in_preg;
            $medical->heart_disease = $heart_disease;
            $medical->pre_eclampsia = $pre_eclampsia;
            $medical->still_birth = $still_birth;
            $medical->post_partum_haemorrhage = $post_partum_haemorrhage;
            $medical->ante_partum_haemorrhage = $ante_partum_haemorrhage;
            $medical->two_more_miscarriages = $two_more_miscarriages;
            $medical->h_macrosomia_45kg = $h_macrosomia_45kg;
            $medical->h_low_birth_weight = $h_low_birth_weight;
            $medical->h_birth_defects = $h_birth_defects;
            $medical->history_of_clot = $history_of_clot;
            $medical->myomectomy = $myomectomy;
            $medical->previous_c_s = $previous_c_s;
            $medical->number_of_c_s = $number_of_c_s;
            $medical->epileptic = $epileptic;
            $medical->asthmatic = $asthmatic;
            $medical->patient_id = $patientID;
            $medical->hospital_id = $hospitalID;
            $medical->doctor_id = $doctorID;
            $medical->hospital_admin_id = $adminID;
            $medical->patient_type_id = $patientTypeID;
            $isSaved = $medical->save();

            if($isSaved){
                return $this->sendResponse($medical, 200);
            }
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/editMedicalHistory",
     *     description="add medical history for specific patient",
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="medicalid",
     *         in="formData",
     *         type="number",
     *         description="Medical history id",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctorid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="patienttypeid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * 
     * @SWG\Parameter(
     *         name="hypertension",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="previous_hyper_in_preg",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="diabetes_mellitus",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="previous_dm_in_preg",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="heart_disease",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="pre_eclampsia",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="still_birth",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="post_partum_haemorrhage",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="ante_partum_haemorrhage",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="two_more_miscarriages",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="h_macrosomia_45kg",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="h_low_birth_weight",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="h_birth_defects",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="history_of_clot",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="myomectomy",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="previous_c_s",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="number_of_c_s",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="epileptic",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     * @SWG\Parameter(
     *         name="asthmatic",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=false,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function editMedicalHistory(Request $request)
    {
        $hospitalID = $request->hospitalid;
        $adminID = $request->adminid;
        $medicalID = $request->medicalid;
        $doctorID = $request->doctorid;
        $patientTypeID = $request->patienttypeid;
        $patientID = $request->patientid;
        $hypertension = $request->hypertension;
        $previous_hyper_in_preg = $request->previous_hyper_in_preg;
        $diabetes_mellitus = $request->diabetes_mellitus;
        $previous_dm_in_preg = $request->previous_dm_in_preg;
        $heart_disease = $request->heart_disease;
        $pre_eclampsia = $request->pre_eclampsia;
        $still_birth = $request->still_birth;
        $post_partum_haemorrhage = $request->post_partum_haemorrhage;
        $ante_partum_haemorrhage = $request->ante_partum_haemorrhage;
        $two_more_miscarriages = $request->two_more_miscarriages;
        $h_macrosomia_45kg = $request->h_macrosomia_45kg;
        $h_low_birth_weight = $request->h_low_birth_weight;
        $h_birth_defects = $request->h_birth_defects;
        $history_of_clot = $request->history_of_clot;
        $myomectomy = $request->myomectomy;
        $previous_c_s = $request->previous_c_s;
        $number_of_c_s = $request->number_of_c_s;
        $epileptic = $request->epileptic;
        $asthmatic = $request->asthmatic;

        $checkAdmin = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($checkAdmin == 1){
            $checkMedical = MedicalHistory::where('id', $medicalID)->count();

            if($checkMedical == 1){
                $medical = MedicalHistory::where('id', $medicalID)->first();
                $medical->$hypertension = $hypertension;
                $medical->previous_hyper_in_preg = $previous_hyper_in_preg;
                $medical->diabetes_mellitus = $diabetes_mellitus;
                $medical->previous_dm_in_preg = $previous_dm_in_preg;
                $medical->heart_disease = $heart_disease;
                $medical->pre_eclampsia = $pre_eclampsia;
                $medical->still_birth = $still_birth;
                $medical->post_partum_haemorrhage = $post_partum_haemorrhage;
                $medical->ante_partum_haemorrhage = $ante_partum_haemorrhage;
                $medical->two_more_miscarriages = $two_more_miscarriages;
                $medical->h_macrosomia_45kg = $h_macrosomia_45kg;
                $medical->h_low_birth_weight = $h_low_birth_weight;
                $medical->h_birth_defects = $h_birth_defects;
                $medical->history_of_clot = $history_of_clot;
                $medical->myomectomy = $myomectomy;
                $medical->previous_c_s = $previous_c_s;
                $medical->number_of_c_s = $number_of_c_s;
                $medical->epileptic = $epileptic;
                $medical->asthmatic = $asthmatic;
                $medical->patient_id = $patientID;
                $medical->hospital_id = $hospitalID;
                $medical->doctor_id = $doctorID;
                $medical->hospital_admin_id = $adminID;
                $medical->patient_type_id = $patientTypeID;
                $isSaved = $medical->save();

                if($isSaved){
                    return $this->sendResponse($medical, 200);
                }
            }
            return $this->sendError("Invalid Medical ID", null, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }


    /**
     * @SWG\Post(
     *     path="/showMedicalHistory",
     *     description="",
     * @SWG\Parameter(
     *         name="patientid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */

    public function showMedicalHistory(Request $request)
    {
        $hospitalID = $request->hospitalid;
        $patientID = $request->patientid;

        $check = MedicalHistory::where('patient_id', $patientID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $patient = MedicalHistory::where('patient_id', $patientID)->where('hospital_id', $hospitalID)->get();

            return $this->sendResponse($patient, 200);
        }
        return $this->sendError("Invalid Patient or Hospital ID for Medical History", null, 200);
    }



    /**
     * @SWG\Post(
     *     path="/allPatientsMedicalHistory",
     *     description="",
     * @SWG\Parameter(
     *         name="adminid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospitalid",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function allPatientsMedicalHistory(Request $request)
    {
        $hospitalID = $request->hospitalid;
        $adminID = $request->adminid;

        $check = HospitalAdmin::where('id', $adminID)->where('hospital_id', $hospitalID)->count();

        if($check == 1){
            $patients = MedicalHistory::where('hospital_id', $hospitalID)->get();

            return $this->sendResponse($patients, 200);
        }
        return $this->sendError("Invalid Admin or Hospital ID", null, 200);
    }

    // **********************************************************Antenatal******************************************************

    /**
     * @SWG\Post(
     *     path="/addAntenatalPatientAPI",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="age",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="sex",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="phone_number",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="address",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *  @SWG\Parameter(
     *         name="dob",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="names",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function addAntenatalPatientAPI(Request $request){

        $hospital_id = $request->hospital_id;
        $doctor_id = $request->doctor_id;
        $patient_id = $request->patient_id;
        $hospital_admin_id = $request->hospital_admin_id;
        $age = $request->age;
        $sex = $request->sex;
        $phone_number = $request->phone_number;
        $address = $request->address;
        $names = $request->names;
        $dob= $request->dob;
        $social = $request->social;
        $medical = $request->medical;



        $count = \App\Patient::where("patient_id", $patient_id)->count();

        if($count == 0){

            $patient = new \App\Patient();
            $patient->hospital_id = $hospital_id;
            $patient->doctor_id = $doctor_id;
            $patient->patient_id = $patient_id;
            $patient->hospital_admin_id = $hospital_admin_id;
            $patient->patient_type_id = 3;
            $patient->age = $age;
            $patient->sex = $sex;
            $patient->names = $names;
            $patient->address = $address;
            $patient->assigned_doctor = $doctor_id;
            $patient->status = 'enable';

            if ($request->hasFile("image_path")){
                $destination = "doctor";
                $file = $request->image_path;
                $extension = $file->getClientOriginalExtension();
                $fileName = $names . rand(1111, 9999) . "." . $extension;
                $file->move($destination, $fileName);

                $patient->image_path = $fileName;

            }

            $isSaved = $patient->save();

            if ($isSaved){

                $socialMedical = new \App\SocialMedical();
                $socialMedical->patient_id = $patient->id;
                $socialMedical->social = $social;
                $socialMedical->medical = $medical;
                $socialMedical->save();

                return $this->sendResponse($patient, 'success');




            }else{
                return $this->sendResponse("failed", 'Please try again');
            }
        }else{
            return $this->sendResponse("failed", 'Patient id Exist');
        }

    }


    /**
     * @SWG\Post(
     *     path="/getAntenatalPatient",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function getAntenatalPatient(Request $request){

        $hospital_id = $request->hospital_id;

        $patient = \App\Patient::where("hospital_id", $hospital_id)->where("patient_type_id", 3)->orderBy("created_at", "desc")->get();

        return $this->sendResponse($patient, 'Patient Retrieved');

    }


    /**
     * @SWG\Post(
     *     path="/addAntenatal",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="Impression",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="Investigation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="Complaints",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="ActionTaken",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *  @SWG\Parameter(
     *         name="request_review",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function addAntenatal(Request $request){



        $patient_id = $request->patient_id;
        $assessment = $request->assessment;
        $Impression = $request->Impression;
        $Investigation = $request->Investigation;
        $Complaints = $request->Complaints;
        $ActionTaken = $request->ActionTaken;
        $request_review = $request->request_review;

        $antenatal = new \App\Antenatal();
        $antenatal->patient_id = $patient_id;
        $antenatal->assessment = $assessment;
        $antenatal->Impression = $Impression;
        $antenatal->Investigation = $Investigation;
        $antenatal->Complaints = $Complaints;
        $antenatal->ActionTaken = $ActionTaken;
        $antenatal->request_review = $request_review;


        $isSaved = $antenatal->save();

        if ($isSaved){

            return $this->sendResponse("success", 'success');

        }else{
            return $this->sendResponse("failed", 'Please try again');
        }


    }


    /**
     * @SWG\Post(
     *     path="/getAntenatal",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function getAntenatal(Request $request){

        $patient_id = $request->patient_id;

        $antenatal = \App\Antenatal::where("patient_id", $patient_id)->orderBy("created_at", "desc")->get();

        return $this->sendResponse($antenatal, 'success');

    }


    /**
     * @SWG\Post(
     *     path="/getMedicalSocial",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function getMedicalSocial(Request $request){

        $patient_id = $request->patient_id;

        $socialMedical = \App\SocialMedical::where("patient_id", $patient_id)->orderBy("created_at", "desc")->first();

        return $this->sendResponse($socialMedical, 'success');

    }



    /**
     * @SWG\Post(
     *     path="/addLaborPatientAPI",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="doctor_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="hospital_admin_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="age",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="sex",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="phone_number",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="address",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *  @SWG\Parameter(
     *         name="dob",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="names",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function addLaborPatientAPI(Request $request){

        $hospital_id = $request->hospital_id;
        $doctor_id = $request->doctor_id;
        $patient_id = $request->patient_id;
        $hospital_admin_id = $request->hospital_admin_id;
        $age = $request->age;
        $sex = $request->sex;
        $phone_number = $request->phone_number;
        $address = $request->address;
        $names = $request->names;
        $dob= $request->dob;
        $social = $request->social;
        $medical = $request->medical;



        $count = \App\Patient::where("patient_id", $patient_id)->count();

        if($count == 0){

            $patient = new \App\Patient();
            $patient->hospital_id = $hospital_id;
            $patient->doctor_id = $doctor_id;
            $patient->patient_id = $patient_id;
            $patient->hospital_admin_id = $hospital_admin_id;
            $patient->patient_type_id = 2;
            $patient->age = $age;
            $patient->sex = $sex;
            $patient->names = $names;
            $patient->address = $address;
            $patient->assigned_doctor = $doctor_id;
            $patient->status = 'enable';

            if ($request->hasFile("image_path")){
                $destination = "doctor";
                $file = $request->image_path;
                $extension = $file->getClientOriginalExtension();
                $fileName = $names . rand(1111, 9999) . "." . $extension;
                $file->move($destination, $fileName);

                $patient->image_path = $fileName;

            }

            $isSaved = $patient->save();

            if ($isSaved){

                $socialMedical = new \App\SocialMedical();
                $socialMedical->patient_id = $patient->id;
                $socialMedical->social = $social;
                $socialMedical->medical = $medical;
                $socialMedical->save();

                return $this->sendResponse($patient, 'success');




            }else{
                return $this->sendResponse("failed", 'Please try again');
            }
        }else{
            return $this->sendResponse("failed", 'Patient id Exist');
        }

    }


    /**
     * @SWG\Post(
     *     path="/getLaborPatient",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function getLaborPatient(Request $request){

        $hospital_id = $request->hospital_id;

        $patient = \App\Patient::where("hospital_id", $hospital_id)->where("patient_type_id", 2)->orderBy("created_at", "desc")->get();

        return $this->sendResponse($patient, 'Patient Retrieved');

    }



    /**
     * @SWG\Post(
     *     path="/addLabor",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="Impression",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="Investigation",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="Complaints",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     * @SWG\Parameter(
     *         name="ActionTaken",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *  @SWG\Parameter(
     *         name="request_review",
     *         in="formData",
     *         type="string",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */


    public function addLabor(Request $request){



        $patient_id = $request->patient_id;
        $hospital_admin_id = $request->hospital_admin_id;
        $assessment = $request->assessment;
        $Impression = $request->Impression;
        $pelvic_assessment = $request->pelvic_assessment;
        $cervical_dilation = $request->cervical_dilation;
        $plan = $request->plan;
        $Complaints = $request->Complaints;
        $remarks = $request->remarks;
        $request_review = $request->request_review;

        $labor = new \App\Labor();
        $labor->patient_id = $patient_id;
        $labor->hospital_admin_id = $hospital_admin_id;
        $labor->assessment = $assessment;
        $labor->Impression = $Impression;
        $labor->pelvic_assessment = $pelvic_assessment;
        $labor->cervical_dilation = $cervical_dilation;
        $labor->plan = $plan;
        $labor->Complaints = $Complaints;
        $labor->remarks = $remarks;
        $labor->request_review = $request_review;



        $isSaved = $labor->save();

        if ($isSaved){

            return $this->sendResponse("success", 'success');

        }else{
            return $this->sendResponse("failed", 'Please try again');
        }


    }

    /**
     * @SWG\Post(
     *     path="/getLabor",
     *     description="",
     * @SWG\Parameter(
     *         name="patient_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function getLabor(Request $request){

        $patient_id = $request->patient_id;

        $labor = \App\Labor::where("patient_id", $patient_id)->orderBy("created_at", "desc")->get();

        return $this->sendResponse($labor, 'success');

    }


    /**
     * @SWG\Post(
     *     path="/getWalletBalance",
     *     description="",
     * @SWG\Parameter(
     *         name="hospital_id",
     *         in="formData",
     *         type="number",
     *         description="",
     *         required=true,
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Missing Data"
     *     )
     * )
     */
    public function getWalletBalance(Request $request){

        $hospital_id = $request->hospital_id;

        $wallet = \App\WalletEntity::where("hospital_id", $hospital_id)->first();

        $walletAmount = "0";

        if ($wallet != null){
            $walletAmount = $wallet->amount;
        }

        return $this->sendResponse($walletAmount, 'success');

    }


    public function fundWallet(Request $request){

        $hospitalID = $request->hospital_id;
        $nurseID = $request->nurse_id;
        $amount = $request->amount;
        $transactionRef = $request->transactionref;
        $source = $request->source;

        $responseCode = $request->responsecode;
        $responseMessage = $request->responsemessage;
        $paymentGateway = $request->paymentgateway;
        $cardNumber = $request->cardnumber;
        $expiry = $request->expiry;
        $cvv = $request->cvv;
        $token = $request->token;
        $cardType = $request->cardtype;


        $resCount = \App\WalletEntity::where("hospital_id", "=", $hospitalID)->count();

        if ($resCount > 0 ){

            $wallet = \App\WalletEntity::where("hospital_id", "=", $hospitalID)->first();
            $oldAmount = $wallet->amount;

            $newAmount = $oldAmount + $amount;

            $wallet->amount = $newAmount;
            $isSaved = $wallet->save();

            $this->logWalletPurchases($hospitalID, $nurseID, $amount, $transactionRef, $source, $responseCode, $responseMessage, $paymentGateway, $cardNumber, $expiry, $cvv);

            //$this->addToken($userID, $cardNumber, $expiry, $cvv, $cardType, $token, $paymentGateway);

            $response = array(
                'status' => 'successful',
                'message' => 'Wallet Funded'
            );

            return Response::json($response );

        }else{

            $transaction = new \App\WalletEntity();
            $transaction->hospital_id = $hospitalID;
            $transaction->amount = $amount;
            $isSaved = $transaction->save();

            $this->logWalletPurchases($hospitalID, $nurseID, $amount, $transactionRef, $source, $responseCode, $responseMessage, $paymentGateway, $cardNumber, $expiry, $cvv);

           // $this->addToken($userID, $cardNumber, $expiry, $cvv, $cardType, $token, $paymentGateway);

            $response = array(
                'status' => 'successful',
                'message' => 'Wallet Funded'
            );

            return Response::json($response );
        }
    }


    public function logWalletPurchases($hospitalID, $nurseID, $amount, $transactionRef, $source, $responseCode, $responseMessage, $paymentGateway, $cardNumber, $expiry, $cvv){
        $transaction = new \App\WalletTransaction();
        $transaction->hospital_id = $hospitalID;
        $transaction->hospital_admin_id = $nurseID;
        $transaction->amount = $amount;
        $transaction->transaction_reference = $transactionRef;
        $transaction->source = $source;
        $transaction->response_code = $responseCode;
        $transaction->response_message = $responseMessage;
        $transaction->payment_gateway = $paymentGateway;
        $transaction->card_number = $cardNumber;
        $transaction->expiry = $expiry;
        $transaction->cvv = $cvv;
        $transaction->save();

    }



}