<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 2/17/2020
 * Time: 1:53 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\AdminEntity;
use App\Http\Controllers\Controller;

use Softon\SweetAlert\Facades\SWAL;

class HospitalController extends controller
{

    public function login(){
        return view("login");
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect("/hospital/login");
    }

    public function register(){
        return view("register");
    }

    public function registerAction(Request $request){
        $name = $request->name;
        $address = $request->address;
        $lga = $request->lga;
        $state = $request->state;

        $fullname = $request->fullname;
        $email = $request->email;
        $password = $request->password;
        $password = md5($password);
        $confirmpassword = $request->confirmpassword;
        $confirmpassword = md5($confirmpassword);

        if ($password == $confirmpassword){

            $hospital = \App\Hospital::where("health_centre_name", $name)->first();

            if ($hospital == null){

                $hospital = new \App\Hospital();
                $hospital->health_centre_name = $name;
                $hospital->address = $address;
                $hospital->city = $lga;
                $hospital->state = $state;
                $hospital->save();

                $hospitalID = $hospital->id;

                $admin = new \App\AdminAdmin();
                $admin->names = $fullname;
                $admin->email = $email;
                $admin->phone_number = '';
                $admin->password = $password;
                $admin->status = 'enable';
                $admin->code = md5($email);
                $admin->hospital_id = $hospitalID;
                $admin->save();

                $adminID = $admin->id;

                $request->session()->put("ospicareFullNames", $fullname);
                $request->session()->put("ospicareEmail", $email);
                $request->session()->put("ospicareAdminID", $adminID);
                $request->session()->put("ospicareHospitalID", $hospitalID);


                return redirect("/hospital/index");

            }else{
                SWAL::message(' Failed','Operation Failed..Please try again!','error',['timer'=>2000]);

            }


        }else{
            SWAL::message('Failed','Password Mismatch..Please try again!','error',['timer'=>2000]);
        }


    }

    public function loginAction(Request $request){
        $email = $request->email;
        $password = $request->password;
        $password = md5($password);

        $count = \App\AdminAdmin::where("email", $email)->where("password",$password)->where("status","enable")->count();

        if($count == 1){

            $query = DB::table('admin_admin')
                ->select('admin_admin.*')
                ->where('email', '=', $email)
                ->first();

            $fullnames = $query->names;
            $adminID = $query->id;
            $hospitalID = $query->hospital_id;

            $request->session()->put("ospicareFullNames", $fullnames);
            $request->session()->put("ospicareEmail", $email);
            $request->session()->put("ospicareAdminID", $adminID);
            $request->session()->put("ospicareHospitalID", $hospitalID);

            return redirect("/hospital/index");
        }else{
            SWAL::message('Authentication Failed','Invalid Email or Password..Please try again!','error',['timer'=>2000]);
        }

        return view("login");
    }


    public function index(){


        $hospitalID = Session::get('ospicareHospitalID');

       // dd ($hospitalID);

        $patients = \App\Patient::where("hospital_id", $hospitalID)->count();

        $doctors = \App\HospitalDoctor::where("hospital_id", $hospitalID)->count();

        $nurse = \App\HospitalAdmin::where("hospital_id", $hospitalID)->count();

        $wallet = \App\WalletEntity::where("hospital_id", $hospitalID)->first();

        $walletAmount = "0";

        if ($wallet != null){
            $walletAmount = $wallet->amount;
        }


        /*

        $totalGiving = DB::table('giving_transaction_table')->where('response_message', 'like', 'Approved%')->sum('amount');

        $userCount = \App\UserModel::count();

        $giveTransactionCount = \App\GiveTransactionModel::where('response_message', 'like', 'Approved%')->count();

        $ResourceTransactionCount = \App\ResourceTransactionModel::where('response_message', 'like', 'Approved%')->count();



        $label = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        //resource

        $resourceReturnValue = $this->totalResourceTransactionnSumByMonth();

        $resourceValue = array(0,0,0,0,0,0,0,0,0,0,0,0);

        foreach($resourceReturnValue as $item){

            $resourceValue[$item->month - 1] = $item->amount;

        }


        $resourcechartjs = app()->chartjs
            ->name('ResourceSummaryBar')
            ->type('bar')
            ->size(['width' => 400, 'height' => 100])
            ->labels($label)
            ->datasets([

                [
                    "label" => "This Month Total Resource Purchase",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $resourceValue
                ]
            ])
            ->options([]);


        //giving

        $givingReturnValue = $this->totalGivingTransactionnSumByMonth();

        $givingValue = array(0,0,0,0,0,0,0,0,0,0,0,0);

        foreach($givingReturnValue as $item){

            $givingValue[$item->month - 1] = $item->amount;

        }


        $givingchartjs = app()->chartjs
            ->name('GivingSummaryBar')
            ->type('bar')
            ->size(['width' => 400, 'height' => 100])
            ->labels($label)
            ->datasets([

                [
                    "label" => "This Month Total Giving",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $givingValue
                ]
            ])
            ->options([]);


        return view("index", compact('givingchartjs', 'resourcechartjs', 'totalGiving', 'userCount', 'giveTransactionCount', 'ResourceTransactionCount'));

        */

        return view("index", compact('patients', 'doctors', 'nurse', 'walletAmount'));

    }

    public function allAdmin(){

        $hospitalID = Session::get('ospicareHospitalID');

        // dd ($hospitalID);

        $admin = \App\AdminAdmin::where("hospital_id", $hospitalID)->orderBy('created_at', 'desc')->get();

        return view("admin", compact("admin"));
    }

    public function addAdmin(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');

        $fullnames = $request->fullnames;
        $email = $request->email;
        $password = $request->password;
        $password = md5($password);
        $status = $request->status;


        $cat = \App\AdminAdmin::where('email', '=', $email)->first();

        if ($cat === null) {

            $admin = new \APP\AdminAdmin();
            $admin->names = $fullnames;
            $admin->email = $email;
            $admin->password = $password;
            $admin->status = $status;
            $admin->hospital_id = $hospitalID;
            $isSaved = $admin->save();

            if($isSaved){

                SWAL::message('Successful','Admin Created added!', 'success',['timer'=>2000]);

            }else{
                SWAL::message('Warning','Admin not added!','error',['timer'=>2000]);
            }

        }else{
            SWAL::message('Warning','Email Already Exists!','info',['timer'=>2000]);
        }


        $admin = \App\AdminAdmin::where("hospital_id", $hospitalID)->orderBy('created_at', 'desc')->get();

        return view("admin", compact('admin'));

    }


    public function editAdmin(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');


        $id = $request->id;
        $fullnames = $request->fullnames;
        $email = $request->email;
        $status = $request->status;


        $admin = \App\AdminAdmin::find($id);

        $admin->names = $fullnames;
        $admin->email = $email;
        $admin->status = $status;
        $isSaved = $admin->save();


        if ($isSaved){

            SWAL::message('Successful','Operation successfully!', 'success',['timer'=>2000]);

        }else{
            SWAL::message('Warning','Record not updated!','error');
        }


        $admin = \App\AdminAdmin::where("hospital_id", $hospitalID)->orderBy('created_at', 'desc')->get();

        return view("admin", compact('admin'));

    }



    public function deleteAdmin(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');

        $id = $request->id;
        $res = \App\AdminAdmin::where('id',$id)->delete();

        SWAL::message('Successful','Operation successfully!', 'success',['timer'=>2000]);

        $admin = \App\AdminAdmin::where("hospital_id", $hospitalID)->orderBy('created_at', 'desc')->get();

        return view("admin", compact('admin'));

    }


    public function allDoctors(){

        $hospitalID = Session::get('ospicareHospitalID');


        $doctors = DB::table('hospital_doctor')
            ->join('doctor', 'doctor_id', '=', 'doctor.id')
            ->select('doctor.*')
            ->where('hospital_id', $hospitalID)
            ->orderBy('created_at', 'desc')
            ->get();


        return view("doctor", compact("doctors"));
    }


    public function addDoctor(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');

        $names = $request->names;
        $specialty = $request->specialty;
        $gender = $request->gender;
        $email = $request->email;
        $password = $request->password;
        $password = hash('sha256', $password);
        $phonenumber = $request->phonenumber;
        $bio = $request->bio;

        if ($request->hasFile("file")){
            $destinationPath = "profilePhoto";
            $file = $request->file;
            $extension = $file->getClientOriginalExtension();
            $fileName = $names . rand(1111,9999) . "." . $extension;

            $photo = $fileName;
            $photo = preg_replace('/\s+/', '', $photo);

            $file->move($destinationPath, $photo);

        }else{
            $photo = "";
        }

        //  "profile", "names", "email","phone_number", "sex", "level","password", "status", "token", "image_path", "code",  "is_independent","firebase_android", "firebase_ios", "registering_body", "registration_number", "created_at"];


        $doctor = new \App\Doctor();
        $doctor->names = $names;
        $doctor->specialty = $specialty;
        $doctor->email = $email;
        $doctor->phone_number = $phonenumber;
        $doctor->sex = $gender;
        $doctor->password = $password;
        $doctor->doctor_type_id = 2;
        $doctor->profile = $bio;
        $doctor->status = 'enabled';
        $doctor->availability = 1;
        if ($request->hasFile("file")){
            $doctor->image_path = $photo;
        }

        $isSaved = $doctor->save();

        if($isSaved){


            $doctorID = $doctor->id;

            $hospitalDoctor = new \App\HospitalDoctor();
            $hospitalDoctor->hospital_id = $hospitalID;
            $hospitalDoctor->doctor_id = $doctorID;
            $hospitalDoctor->save();

            SWAL::message('Successful','Doctor Successfully added!','success',['timer'=>2000]);



        }else{

            SWAL::message('Failed','Operation failed...Please try again!','error');

        }




        $doctors = DB::table('hospital_doctor')
            ->join('doctor', 'doctor_id', '=', 'doctor.id')
            ->select('doctor.*')
            ->where('hospital_id', $hospitalID)
            ->orderBy('created_at', 'desc')
            ->get();


        return view("doctor", compact("doctors"));

    }


    public function deleteDoctor(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');

        $id = $request->deleteuserid;
        $res = \App\Doctor::where('id',$id)->delete();

        SWAL::message('Successful','Operation successfully!', 'success',['timer'=>2000]);

        $doctors = DB::table('hospital_doctor')
            ->join('doctor', 'doctor_id', '=', 'doctor.id')
            ->select('doctor.*')
            ->where('hospital_id', $hospitalID)
            ->orderBy('created_at', 'desc')
            ->get();


        return view("doctor", compact("doctors"));

    }


    public function allNurse(){

        $hospitalID = Session::get('ospicareHospitalID');

        // dd ($hospitalID);

        $admin = \App\HospitalAdmin::where("hospital_id", $hospitalID)->orderBy('created_at', 'desc')->get();

        return view("nurse", compact("admin"));
    }

    public function addNurse(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');

        $fullnames = $request->fullnames;
        $email = $request->email;
        $password = $request->password;
        $password = md5($password);
        $status = $request->status;


        $cat = \App\HospitalAdmin::where('email', '=', $email)->first();

        if ($cat === null) {

            $admin = new \APP\HospitalAdmin();
            $admin->names = $fullnames;
            $admin->email = $email;
            $admin->password = $password;
            $admin->status = $status;
            $admin->hospital_id = $hospitalID;
            $isSaved = $admin->save();

            if($isSaved){

                SWAL::message('Successful','Admin Created added!', 'success',['timer'=>2000]);

            }else{
                SWAL::message('Warning','Admin not added!','error',['timer'=>2000]);
            }

        }else{
            SWAL::message('Warning','Email Already Exists!','info',['timer'=>2000]);
        }


        $admin = \App\HospitalAdmin::where("hospital_id", $hospitalID)->orderBy('created_at', 'desc')->get();

        return view("nurse", compact("admin"));

    }


    public function editNurse(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');


        $id = $request->id;
        $fullnames = $request->fullnames;
        $email = $request->email;
        $status = $request->status;


        $admin = \App\HospitalAdmin::find($id);

        $admin->names = $fullnames;
        $admin->email = $email;
        $admin->status = $status;
        $isSaved = $admin->save();


        if ($isSaved){

            SWAL::message('Successful','Operation successfully!', 'success',['timer'=>2000]);

        }else{
            SWAL::message('Warning','Record not updated!','error');
        }


        $admin = \App\HospitalAdmin::where("hospital_id", $hospitalID)->orderBy('created_at', 'desc')->get();

        return view("nurse", compact("admin"));

    }



    public function deleteNurse(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');

        $id = $request->id;
        $res = \App\HospitalAdmin::where('id',$id)->delete();

        SWAL::message('Successful','Operation successfully!', 'success',['timer'=>2000]);

        $admin = \App\HospitalAdmin::where("hospital_id", $hospitalID)->orderBy('created_at', 'desc')->get();

        return view("nurse", compact("admin"));

    }


    public function allPatient(){

        $hospitalID = Session::get('ospicareHospitalID');


        $patient = DB::table('patient')
            ->join('doctor', 'doctor_id', '=', 'doctor.id')
            ->select('patient.*', 'doctor.names as doctor_name')
            ->where('hospital_id', $hospitalID)
            ->orderBy('created_at', 'desc')
            ->get();


        return view("patient", compact("patient"));
    }


    public function deletePatient(Request $request){

        $hospitalID = Session::get('ospicareHospitalID');

        $id = $request->id;
        $res = \App\Patient::where('id',$id)->delete();

        SWAL::message('Successful','Operation successfully!', 'success',['timer'=>2000]);

        $patient = DB::table('patient')
            ->join('doctor', 'doctor_id', '=', 'doctor.id')
            ->select('patient.*', 'doctor.names as doctor_name')
            ->where('hospital_id', $hospitalID)
            ->orderBy('created_at', 'desc')
            ->get();


        return view("patient", compact("patient"));

    }


    public function adminProfile(){

        $adminID = Session::get('ospicareAdminID');

        $admin = \App\AdminAdmin::where('id', $adminID)->first();

        return view("editprofile", compact('admin'));


    }

    public function updateProfile(Request $request){

        $adminid = $request->id;
        $fullnames = $request->fullnames;
        $email = $request->email;
        $phonenumber = $request->phonenumber;

        $admin = \App\AdminAdmin::where('id', $adminid)->first();

        $admin->names = $fullnames;
        $admin->email = $email;
        $admin->phone_number = $phonenumber;

        $isSaved = $admin->save();


        if ($isSaved){

            SWAL::message('Successful','Profile Updated!!!', 'success',['timer'=>2000]);


            $fullnames = $admin->names;
            $email = $admin->email;


            $request->session()->put("ospicareFullNames", $fullnames);
            $request->session()->put("ospicareEmail", $email);
            $request->session()->put("ospicareAdminID", $adminid);



        }else{
            SWAL::message('Warning','Not updated!','error',['timer'=>2000]);
        }



        $adminID = Session::get('ospicareAdminID');

        $admin = \App\AdminAdmin::where('id', $adminID)->first();

        return view("editprofile", compact('admin'));



    }

    public function editPassword(){


        $email = Session::get('ospicareEmail');

        $admin = \App\AdminAdmin::where("email", $email)->first();

        return view ("changepassword",compact('admin'));

    }


    public function updatePassword(Request $request){

        $adminID = $request->id;
        $oldpassword = $request->oldpassword;
        $oldpassword = md5($oldpassword);

        $newpassword = $request->newpassword;
        $newpassword = md5($newpassword);

        $confirmnewpassword = $request->confirmnewpassword;
        $confirmnewpassword = md5($confirmnewpassword);


        if ($newpassword == $confirmnewpassword){

            $count = \App\AdminAdmin::where("id", $adminID)->where("password",$oldpassword)->count();


            if($count == 1){

                $admin = \App\AdminAdmin::where("id", $adminID)->first();

                $admin->password = $newpassword;
                $isSaved = $admin->save();
                if ($isSaved){

                    SWAL::message('Successful','Password Updated!!!', 'success',['timer'=>2000]);

                }else{
                    SWAL::message('Warning','Not updated!','error',['timer'=>2000]);
                }

            }else{
                SWAL::message('Warning','Invalid Old Password..Please try again!','error',['timer'=>2000]);
            }


        }else{
            SWAL::message('Warning','Password Mismatch!','error',['timer'=>2000]);
        }

        $email = Session::get('ospicareEmail');

        $admin = \App\AdminAdmin::where("email", $email)->first();

        return view ("changepassword",compact('admin'));
    }

    public function changePassword(){

        $adminID = Session::get('ospicareAdminID');

        return view('changepassword', compact('adminID'));
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

    public function fundHistory(){

        $hospitalID = Session::get('ospicareHospitalID');

        $transaction = DB::table('wallet_transaction')
            ->join('hospital_admin', 'hospital_admin_id', '=', 'hospital_admin.id')
            ->select('wallet_transaction.*', 'hospital_admin.names as nurse_name')
            ->where('wallet_transaction.hospital_id', $hospitalID)
            ->orderBy('created_at', 'desc')
            ->get();

        return view("wallethistory", compact("transaction"));
    }

}