<?php

use App\Invoice;
use \Firebase\JWT\JWT;


// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
require_once('../../config/config.php');
require_once('../../includes/functions.php');
require_once("../../autoload.php");
require "../../vendor/autoload.php";
include_once '../user/core.php';


if (isset($_SERVER["HTTP_AUTHORIZATION"]) & !empty($_GET["id"])) {
    $auth = $_SERVER["HTTP_AUTHORIZATION"];
    $id = $_GET["id"];


        try {
            // decode jwt
            $decoded = JWT::decode($auth, $key, array('HS256'));

            var_dump($_SERVER["REQUEST_METHOD"]);

            echo intval($_GET["id"]);

            // set response code
            http_response_code(200);

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
    echo json_encode(array("message" => "Invoice id and auth token are empty"));

}


// get product id
$data = json_decode(file_get_contents("php://input"));
// delete the product

$id = $data->id;



$invoice = Invoice::findById($id);

if (!$invoice) {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Invoice does not exist."));
} else {
    if(Invoice::deleteInvoice($data->id)){

        // set response code - 200 ok
        http_response_code(200);

        // tell the user
        echo json_encode(array("message" => "Invoice has been deleted."));
    }

// if unable to delete the product
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to delete invoice."));
    }
}

