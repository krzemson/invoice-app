<?php

use App\Invoice;
use \Firebase\JWT\JWT;
use \App\API;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8; multipart/form-data");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../../vendor/autoload.php";
require_once('../../config/config.php');
require_once('../../includes/functions.php');
require_once("../../autoload.php");
include_once '../user/core.php';

if (isset($_SERVER["HTTP_AUTHORIZATION"]) & !empty($_SERVER["HTTP_AUTHORIZATION"])) {
    $auth = $_SERVER["HTTP_AUTHORIZATION"];
    $request_method=$_SERVER["REQUEST_METHOD"];

    $api = new API();

    switch ($request_method) {
        case 'GET':
            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]);

                try {
                    // decode jwt
                    if ($id !== 0) {
                        $decoded = JWT::decode($auth, $key, array('HS256'));

                        $api->oneInvoice($id);
                    } else {
                        http_response_code(404);

                        // tell the user product does not exist
                        echo json_encode(array("message" => "Invoice does not exist"));
                    }

                } catch (Exception $e) {
                    // set response code
                    http_response_code(401);

                    // tell the user access denied  & show error message
                    echo json_encode(array(
                        "message" => "Access denied.",
                        "error" => $e->getMessage()
                    ));
                }
            } else {
                try {
                    // decode jwt
                    $decoded = JWT::decode($auth, $key, array('HS256'));

                    $id = $decoded->data->id;

                    $api->allInvoices($id);

                } catch (Exception $e) {
                    // set response code
                    http_response_code(401);

                    // tell the user access denied  & show error message
                    echo json_encode(array(
                        "message" => "Access denied.",
                        "error" => $e->getMessage()
                    ));
                }
            }
            break;
        case 'POST':
            try {
                // decode jwt
                $decoded = JWT::decode($auth, $key, array('HS256'));

                $data = json_decode(file_get_contents("php://input"));

                $api->createInvoice($data);

            } catch (Exception $e) {
                // set response code
                http_response_code(401);

                // tell the user access denied  & show error message
                echo json_encode(array(
                    "message" => "Access denied.",
                    "error" => $e->getMessage()
                ));
            }
            break;
        case 'PUT':
            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]);

                try {
                    // decode jwt
                    if ($id !== 0) {
                        $decoded = JWT::decode($auth, $key, array('HS256'));

                        $data = json_decode(file_get_contents("php://input"));

                        $api->updateInvoice($id, $data);


                    } else {
                        http_response_code(404);

                        // tell the user product does not exist
                        echo json_encode(array("message" => "Invoice does not exist."));
                    }

                } catch (Exception $e) {
                    // set response code
                    http_response_code(401);

                    // tell the user access denied  & show error message
                    echo json_encode(array(
                        "message" => "Access denied.",
                        "error" => $e->getMessage()
                    ));
                }
            } else {
                http_response_code(404);

                echo json_encode(array("message" => "Invoice does not exist."));
            }
            break;
        case 'DELETE':

            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]);

                try {
                    // decode jwt
                    if ($id !== 0) {
                        $decoded = JWT::decode($auth, $key, array('HS256'));

                        $api->deleteInvoice($id);
                    } else {
                        http_response_code(404);

                        // tell the user product does not exist
                        echo json_encode(array("message" => "Invoice does not exist."));
                    }

                } catch (Exception $e) {
                    // set response code
                    http_response_code(401);

                    // tell the user access denied  & show error message
                    echo json_encode(array(
                        "message" => "Access denied.",
                        "error" => $e->getMessage()
                    ));
                }
            } else {
                http_response_code(404);

                // tell the user product does not exist
                echo json_encode(array("message" => "Invoice does not exist."));
            }


            break;
        default:
            // Invalid Request Method
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
} else {
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Auth token is empty"));

}

