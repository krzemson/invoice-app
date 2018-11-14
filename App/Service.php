<?php
/**
 * Created by PhpStorm.
 * User: krzemson
 * Date: 14.11.2018
 * Time: 18:22
 */

namespace App;


class Service
{
    protected static $table = "services";
    protected $fillable = ['invoice_id', 'service', 'quantity', 'unit', 'net', 'netv', 'tax', 'taxv', 'gross'];
}