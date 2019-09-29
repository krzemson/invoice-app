<?php
use \Firebase\JWT\JWT;
use \App\API;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../../vendor/autoload.php";
require_once('../../config/config.php');

require_once("../../autoload.php");
include_once 'core.php';

$client = new API();

// get posted data
$data = json_decode(file_get_contents("php://input"));

$username=isset($data->username) ? $data->username : "";
$password=isset($data->password) ? $data->password : "";

if ($username && $password) {
// set product property values

    $username = $data->username;
    $password = $data->password;

    $client->login($username, $password);

    if ($client->validate()) {
        if ($user = $client->verify()) {
            $token = array(
                "iss" => $iss,
                "aud" => $aud,
                "iat" => $iat,
                "nbf" => $nbf,
                "data" => array(
                    "id" => $user->id,
                    "username" => $user->username,
                    "name" => $user->name,
                    "surname" => $user->surname,
                    "email" => $user->email
                )
            );

            // set response code
            http_response_code(200);

            // generate jwt
            $jwt = JWT::encode($token, $key);
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "id" => $user->id,
                    "username" => $user->username,
                    "name" => $user->name,
                    "surname" => $user->surname,
                    "email" => $user->email,
                    "jwt" => $jwt
                )
            );
        } else {
            // set response code
            http_response_code(401);

            // tell the user login failed
            echo json_encode(array("message" => "Login failed."));
        }
    }
} else {
    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}