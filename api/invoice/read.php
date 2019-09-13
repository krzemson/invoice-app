<?php
use App\Invoice;
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require "../../vendor/autoload.php";
require_once('../../config/config.php');
require_once('../../includes/functions.php');
require_once("../../autoload.php");
include_once '../user/core.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";


if ($jwt) {
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        // set response code
        http_response_code(200);

        // show user details
        echo json_encode(array(
            "message" => "Access granted.",
            "data" => $decoded->data
        )) . "\n";

        if ($invoices = Invoice::findAllInvoices($id)) {
            // products array
            $invoice_arr = array();
            $invoice_arr["faktury"] = array();

            foreach ($invoices as $invoice) {
                $invoice_item=array(
                    "id" => $invoice->id,
                    "nr_faktury" => $invoice->invnum,
                    "wartosc_brutto" => $invoice->gross_value,
                    "wartosc_netto" => $invoice->net_value,
                    "termin" => $invoice->term_payment
                );

                array_push($invoice_arr["faktury"], $invoice_item);
            }

            http_response_code(200);

            echo json_encode($invoice_arr);
        } else {
            http_response_code(404);

            echo json_encode(
                array("message" => "No products found.")
            );
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
        // set response code
        http_response_code(401);

        // tell the user access denied
        echo json_encode(array("message" => "Access denied."));


}
