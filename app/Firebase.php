<?php


namespace App;


class Firebase
{

    public function send($registration_ids, $message, $body, $title) {
        $fields = array(
            'to' => $registration_ids,
            'data' => $message,
            'notification' => array(
                "body" => $body,
                "title" => $title,
            )
        );
        return $this->sendPushNotification($fields);
    }

    /*
    * This function will make the actuall curl request to firebase server
    * and then the message is sent
    */
    private function sendPushNotification($fields) {

        //importing the constant files
        $firebaseAPIKey = "AAAAaivbFvw:APA91bGAhoKLBgusgojB2cNa9SrFiwt8NdUZtUhFAG4FZ6hfAX-4aMMKjjFd_pqayZoz-VzwWgzFVlabV007DImLmHyRiOJ_iJeX4EpFfN2CKTI8VT3h20edYb245ZBrESigngBgGVxi";

        //firebase server url to send the curl request
        $url = 'https://fcm.googleapis.com/fcm/send';

        //building headers for the request
        $headers = array(
            'Authorization: key=' . $firebaseAPIKey,
            'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();

        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);

        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);

        //adding headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //adding the fields in json format
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        //finally executing the curl request
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        //Now close the connection
        curl_close($ch);

        //and return the result
        return $result;
    }
}