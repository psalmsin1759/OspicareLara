<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 6/13/2018
 * Time: 8:59 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Response;


class APIBaseController extends Controller
{

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return Response::json($response, 200 );
    }


    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return Response::json($response, 200 );
    }

}