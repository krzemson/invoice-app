<?php
use App\Invoice;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
require_once('../../config/config.php');
require_once('../../includes/functions.php');
require_once("../../autoload.php");


// set ID property of record to read
$id = isset($_GET['id']) ? $_GET['id'] : die();

$invoice = Invoice::findById($id);

if($invoice->id != null){
    // create array
    $product_arr = array(
        "id" => $invoice->id,
        "nr_faktury" => $invoice->invnum,
        "wartosc_brutto" => $invoice->gross_value,
        "wartosc_netto" => $invoice->net_value,
        "termin" => $invoice->term_payment
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($product_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "Invoice does not exist."));
}