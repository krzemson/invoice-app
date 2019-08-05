<?php

use App\Invoice;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
require_once('../../config/config.php');
require_once('../../includes/functions.php');
require_once("../../autoload.php");

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited

$id = $data->id;

$invoice = Invoice::findById($id);

// set product property values
/*$invoice->invnum = $data->invnum;
$invoice->user_id = $data->user_id;
$invoice->customer_id = $data->customer_id;
$invoice->payment = $data->payment;
$invoice->inwords = $data->inwords;
$invoice->date_issue = $data->date_issue;
$invoice->date_service = $data->date_service;
$invoice->net_value = $data->net_value;
$invoice->tax_value = $data->tax_value;
$invoice->gross_value = $data->gross_value;
$invoice->term_payment = date('Y-m-d H:i:s');
*/
// update the product

if (!$invoice) {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Invoice does not exist."));
} else {

    if (count((array)$data) < 2) {

        // set response code - 400 bad request
        http_response_code(400);

        // tell the user
        echo json_encode(array("message" => "Unable to update product. Data is incomplete."));
    } else {
        $invoice->invnum = empty($data->invnum) ? $invoice->invnum : $data->invnum;

        if($invoice->save()){

            // set response code - 200 ok
            http_response_code(200);

            // tell the user
            echo json_encode(array("message" => "Product has been updated."));
        }

// if unable to update the product, tell the user
        else{

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the user
            echo json_encode(array("message" => "Unable to update product."));
        }
    }
}