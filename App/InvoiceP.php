<?php

namespace App;


class InvoiceP extends Invoice
{
    protected static $table = 'invoicesP';
    protected $fillable = ['user_id', 'supplier_id', 'invnum', 'net_value', 'tax_value', 'gross_value', 'payment', 'term_payment', 'inwords', 'date_issue', 'date_service'];

    public $id;
    public $user_id;
    public $supplier_id;
    public $invnum;
    public $net_value;
    public $tax_value;
    public $gross_value;
    public $payment;
    public $term_payment;
    public $inwords;
    public $date_issue;
    public $date_service;
    public $invtype = "FZ-";

}