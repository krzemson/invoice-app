<?php

namespace App;

class API
{
    private $invoice;
    private $user;

    public function __construct()
    {
        $this->user = new Login();
        $this->invoice = new Invoice();
    }

    public function login($username, $password)
    {
        $this->user->setUsernameAndPassword($username, $password);
    }

    public function validate()
    {
        return $this->user->validate();
    }

    public function verify()
    {
        return $this->user->verify();
    }

    public function oneInvoice($id)
    {

        if ($invoice = $this->invoice->findById($id)) {
            // create array

            $invoice_arr = array(
                "id" => $invoice->id,
                "nr_faktury" => $invoice->invnum,
                "wartosc_brutto" => $invoice->gross_value,
                "wartosc_netto" => $invoice->net_value,
                "termin" => $invoice->term_payment
            );

            // set response code - 200 OK
            http_response_code(200);

            // make it json format
            echo json_encode($invoice_arr);
        } else {
            // set response code - 404 Not found
            http_response_code(404);

            // tell the user product does not exist
            echo json_encode(array("message" => "Invoice does not exist."));
        }
    }

    public function allInvoices($id)
    {
        if ($invoices = Invoice::findAllInvoices($id)) {
            // products array
            $invoice_arr = array();
            $invoice_arr["faktury"] = array();

            foreach ($invoices as $invoice) {
                $invoice_item=array(
                    "id" => $invoice->id,
                    "nr_faktury" => $invoice->invnum,
                    "klient" => $invoice->customer()->company,
                    "vat" => $invoice->tax_value,
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
    }

    public function deleteInvoice($id)
    {
        if (!Invoice::findById($id)) {
            http_response_code(404);

            echo json_encode(array("message" => "Invoice does not exist."));
        } else {
            if (Invoice::deleteInvoice($id)) {
                http_response_code(200);

                echo json_encode(array("message" => "Invoice has been deleted."));
            } else {
                http_response_code(503);

                echo json_encode(array("message" => "Unable to delete invoice."));
            }
        }
    }

}
