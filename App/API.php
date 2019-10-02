<?php

namespace App;

class API
{
    private $invoice;
    private $user;
    private $customer;

    public function __construct()
    {
        $this->user = new Login();
        $this->invoice = new Invoice();
        $this->customer = new Customer();
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
                array("message" => "No invoices found.")
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

    public function updateInvoice($id, $data)
    {
        if (!$invoice = Invoice::findById($id)) {
            http_response_code(404);

            echo json_encode(array("message" => "Invoice does not exist."));
        } else {
            $invoice->invnum = empty($data->invnum) ? $invoice->invnum : $data->invnum;
            $invoice->customer()->company = empty($data->customer) ? $invoice->customer()->company : $data->customer;
            $invoice->net_value = empty($data->netto) ? $invoice->net_value : $data->netto;
            $invoice->tax_value = empty($data->vat) ? $invoice->tax_value : $data->vat;
            $invoice->gross_value = empty($data->gross) ? $invoice->gross_value : $data->gross;
            $invoice->term_payment = empty($data->term) ? $invoice->term_payment : $data->term;

            if ($invoice->save()) {
                http_response_code(200);

                echo json_encode(array("message" => "Invoice has been updated"));
            } else {
                http_response_code(503);

                echo json_encode(array("message" => "Unable to update invoice"));
            }
        }
    }

    public function createInvoice($data)
    {
        $invoice = $this->invoice;

        $invoice->user_id = intval($data->user);
        $invoice->customer_id = intval($data->customer);
        $invoice->net_value = $data->netto;
        $invoice->tax_value = $data->vat;
        $invoice->gross_value = $data->gross;
        $invoice->term_payment = date('Y-m-d H:i:s');
        $invoice->setInvNum();
        $invoice->setPayment("cash");
        $invoice->inwords = "";
        $invoice->date_issue = date('Y-m-d H:i:s');
        $invoice->date_service = date('Y-m-d H:i:s');

        // create the product
        if ($invoice->save()) {
            http_response_code(201);

            echo json_encode(array("message" => "invoice has been created."));
        } else {
            http_response_code(503);

            echo json_encode(array("message" => "Unable to create invoice."));
        }
    }

    public function oneCustomer($id)
    {

        if ($customer = $this->customer->findById($id)) {
            // create array

            $invoice_arr = array(
                "id" => $customer->id,
                "name" => $customer->name,
                "surname" => $customer->surname,
                "company" => $customer->company,
                "address" => $customer->address,
                "city" => $customer->city,
                "nip" => $customer->nip,
                "regon" => $customer->regon,
            );

            // set response code - 200 OK
            http_response_code(200);

            // make it json format
            echo json_encode($invoice_arr);
        } else {
            // set response code - 404 Not found
            http_response_code(404);

            // tell the user product does not exist
            echo json_encode(array("message" => "Customer does not exist."));
        }
    }

    public function allCustomers($id)
    {
        if ($customers = Customer::findAllCustomers($id)) {
            // products array
            $customer_arr = array();
            $customer_arr["customers"] = array();

            foreach ($customers as $customer) {
                $customer_item=array(
                    "id" => $customer->id,
                    "name" => $customer->name,
                    "surname" => $customer->surname,
                    "company" => $customer->company,
                    "address" => $customer->address,
                    "city" => $customer->city,
                    "regon" => $customer->regon
                );

                array_push($customer_arr["customers"], $customer_item);
            }

            http_response_code(200);

            echo json_encode($customer_arr);
        } else {
            http_response_code(404);

            echo json_encode(
                array("message" => "No invoices found.")
            );
        }
    }

}
