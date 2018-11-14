<?php


namespace App;


class Invoice
{
    protected static $table = 'invoices';
    protected $fillable = ['user_id', 'customer_id', 'invnum', 'net_value', 'tax_value', 'payment', 'term_payment', 'inwords', 'date_issue', 'data_service'];

    public $user_id;
    public $customer_id;
    public $invnum;
    public $net_value;
    public $tax_value;
    public $payment;
    public $erm_payment;
    public $inwords;
    public $date_issue;
    public $data_service;

}