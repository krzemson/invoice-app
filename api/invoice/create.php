<?php
use App\Invoice;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../../config/config.php');
require_once('../../includes/functions.php');
require_once("../../autoload.php");

$invoice = new Invoice();

$data = json_decode(file_get_contents("php://input"));


if(
    !empty($data->invnum) &&
    !empty($data->net_value) &&
    !empty($data->tax_value) &&
    !empty($data->gross_value)
){

    // set product property values
    $invoice->invnum = $data->invnum;
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

    // create the product
    if($invoice->save()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "invoice has been created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create invoice."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create invoice. Data is incomplete."));
}
