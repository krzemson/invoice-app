<?php

use \App\API;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8; multipart/form-data");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../../vendor/autoload.php";
require_once('../../config/config.php');

require_once("../../autoload.php");

    $request_method=$_SERVER["REQUEST_METHOD"];

    $api = new API();

    switch ($request_method) {
        case 'POST':

            $data = json_decode(file_get_contents("php://input"));

            $api->register($data);

            break;
        default:
            // Invalid Request Method
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }