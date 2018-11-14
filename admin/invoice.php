<?php

require('../fpdf/fpdf.php');
require_once ("../init.php");

use App\Invoice;
use App\Service;


$invoice = new Invoice();
$service = new Service();

$invoice->user_id = $_SESSION['userId'];
$invoice->customer_id = $_POST['customer'];
$invoice->date_issue = $_POST['dateiss'];
$invoice->data_service = $_POST['dateser'];
$invoice->payment = $_POST['payment'];


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,"hello");
$pdf->Output();


