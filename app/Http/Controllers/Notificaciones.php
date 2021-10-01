<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Notificaciones extends Controller
{
    //

    function sendMessage($mensaje,$titulo) {
    $content = array(
        "en" => $mensaje
    );
    $headers = array(
        "en"=>$titulo
    );
    $hashes_array = array();
    $fields = array(
        'app_id' => "948291e7-9ea8-4414-80ac-ebde81e3b167",
        'included_segments' => array(
            'All'
        ),
        'data' => array(
            "foo" => "bar"
        ),
        'contents' => $content,
        'headings' => $headers,
    );

    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NWRlYzdkMTMtMzkzYS00OWJkLTgxYWYtYjMzYTVmYzU3NGNh'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }
}
