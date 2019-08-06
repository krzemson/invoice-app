<?php

use App\Customer;
use App\Invoice;
use App\Service;

require_once("../init.php");
require_once '../vendor/autoload.php';

if (!isset($_GET['inv_id'])) {
    redirect('../index.php');
} elseif (isset($_GET['inv_id'])) {
    $inv_id = $_GET['inv_id'];
    $invoice = Invoice::findById($inv_id);
    $customer = $invoice->customer();
    $profile = $invoice->profile();
    $services = $invoice->services();

    try
    {
        $mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp']);

        $html='

<head>
    <title>'.$invoice->invnum.'</title>
    <style>
        .boxes {
        width:45%;
        }

        .number {
            border: 1px solid #000;
        }

        .padding {
            padding-top: 30px;


        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        thead th, tbody td {
            border: 1px solid #000;
        }
        
        table {
            border-collapse: collapse;
        }
        
        th {
            font-weight: normal;
            font-size: 11px;
            padding: 5px;
        }
        
        tbody td, tfoot td {
            font-weight: normal;
            font-size: 10px;
            text-align: right;
            padding: 5px;
        }
        
        .border-cell {
            border: 1px solid #000;
        }

        table {
            width: 100%;
        }

        .sign {
            font-size: 12px;
            padding-top: 100px;
        }
        
        .middle {
            font-size: 12px;
        }
        

    </style>

</head>

<body>
    <div>
        <div class="boxes left"><img src=""></div>
            <div class="boxes right">
                <div class="text-center">
                    Faktura
                </div>
                <div class="number text-center">
                    '.$invoice->invnum.'
                </div>
               <div class="text-right padding middle">
                    <div>ORYGINAŁ</div>
                    <div>Data wystawienia: '.$invoice->date_issue.'</div>
                    <div>Data usługi/wykonania: '.$invoice->date_issue.'</div>
                    <div>Termin zapłaty: '.$invoice->term_payment.'</div>
                </div>
          </div>
    </div>


    <div>
        <div class="boxes padding left middle">
            <div><strong>Nabywca</strong></div>
            <hr>
            <div>'.$customer->company.'</div>
            <div>'.$customer->address.'</div>
            <div>'.$customer->city.'</div>
            <div>'.$customer->nip.'</div>
            <div>'.$customer->regon.'</div>
        </div>
        <div class="boxes padding right middle">
            <div><strong>Sprzedawca</strong></div>
            <hr>
            <div>'.$profile->company.'</div>
            <div>'.$profile->address.'</div>
            <div>'.$profile->city.'</div>
            <div>'.$profile->nip.'</div>
            <div>'.$profile->regon.'</div>
        </div>
    </div>

    <div class="padding">
        <table>
              <thead>
                <tr>
                  <th>LP</th>
                  <th style="text-align: left;">Nazwa towaru lub usługi</th>
                  <th>Ilość</th>
                  <th>JM</th>
                  <th>Cena netto</th>
                  <th>Wartość netto</th>
                  <th>VAT %</th>
                  <th>VAT</th>
                  <th>Wartość brutto</th>
                </tr>
              </thead>
              <tbody>
              
              ';

        $i = 1;

        foreach ($services as $service) {
            $tax = $service->tax*100;
            $html .='
                <tr>
                  <td>'.$i++.'</td>
                  <td style="text-align: left;">'.$service->service.'</td>
                  <td>'.$service->quantity.'</td>
                  <td>'.$service->unit.'</td>
                  <td>'.$service->net.'</td>
                  <td>'.$service->netv.'</td>
                  <td>'.$tax.'%</td>
                  <td>'.$service->taxv.'</td>
                  <td>'.$service->gross.'</td>
                </tr>
                
                
    ';
        }



        $html .= '
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5" style="text-align: right;">Razem:</td>
                  <td class="border-cell">'.$invoice->net_value.'</td>
                  <td class="border-cell"></td>
                  <td class="border-cell">'.$invoice->tax_value.'</td>
                  <td class="border-cell">'.$invoice->gross_value.'</td>
                </tr>
              </tfoot>
          </table>
    </div>
    <div class="padding middle">
        <div>Do zapłaty: '.$invoice->gross_value.' zł</div>
        <div>Słownie: '.$invoice->inwords.'</div>
        <div>Sposób płatności: '.$invoice->payment.'</div>
        <div>Nr konta: </div>
    </div>

    <div>
        <div class="boxes left text-center sign">
            <hr>
            Osoba uprawniona do otrzymania faktury
        </div>
        <div class="boxes right text-center sign">
            <hr>
            Osoba upoważniona do wystawiania faktur
                <div><strong>'.$profile->name.' '.$profile->surname.'</strong></div>
        </div>
    </div>
</body>';

        $mpdf->SetHTMLFooter('
<hr>
<table width="100%" style="vertical-align: bottom; 
    font-size: 8pt; color: #000000; border: 0; ">
    <tr>
        <td width="33%" style="border: 0;">{DATE j-m-Y}</td>
        <td width="33%" align="center" style="border: 0;">Strona {PAGENO} z {nbpg}</td>
        <td width="33%" style="text-align: right; border: 0;">tel./fax <br> kontakt@firma.pl</td>
    </tr>
</table>');

        $mpdf->WriteHTML($html);
        $mpdf->Output();

        return true;
    }
    catch(\Mpdf\MpdfException $e)
    {
        echo $e->getMessage();

        return false;
    }
} else {
    $profile = $session->user();
    $customer = Customer::findById($_POST['customer']);

    $invoice = new Invoice();

    $invoice->user_id = $_SESSION['userId'];
    $invoice->customer_id = $_POST['customer'];
    $invoice->date_issue = $_POST['dateiss'];
    $invoice->date_service = $_POST['dateser'];
    $invoice->setInvNum();
    $invoice->setPayment($_POST['payment']);
    $invoice->net_value = 0;
    $invoice->tax_value = 0;
    $invoice->gross_value = 0;
    $invoice->inwords = "";

    $invoice->save();

    $invoiceId = $invoice->insertId();

    $invoice->id = $invoiceId;

    $services = [];

    for ($i = 0; $i < count($_POST['service']); $i++) {
        $service = new Service();

        $service->invoice_id = $invoiceId;
        $service->service = $_POST['service'][$i];
        $service->quantity = $_POST['quantity'][$i];
        $service->unit = $_POST['jm'];
        $service->net = $_POST['net'][$i];
        $service->setNetValue();
        $service->tax = $_POST['tax'];
        $service->setTaxValue();
        $service->setGrossValue();

        $invoice->net_value = bcadd($invoice->net_value, $service->netv, 2);
        $invoice->tax_value = bcadd($invoice->tax_value, $service->taxv, 2);
        $invoice->gross_value = bcadd($invoice->gross_value, $service->gross, 2);

        $service->save();
        $services[] = $service;
    }

    $invoice->inwords = kwotaslownie($invoice->gross_value);
    $invoice->save();

    try
    {
        $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

        $html='

<head>
    <title>'.$invoice->invnum.'</title>
    <style>
        .boxes {
        width:45%;
        }

        .number {
            border: 1px solid #000;
        }

        .padding {
            padding-top: 30px;


        }

        .left {
            float: left;
        }

        .right {
            float: right;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        thead th, tbody td {
            border: 1px solid #000;
        }
        
        table {
            border-collapse: collapse;
        }
        
        th {
            font-weight: normal;
            font-size: 11px;
            padding: 5px;
        }
        
        tbody td, tfoot td {
            font-weight: normal;
            font-size: 10px;
            text-align: right;
            padding: 5px;
        }
        
        .border-cell {
            border: 1px solid #000;
        }

        table {
            width: 100%;
        }

        .sign {
            font-size: 12px;
            padding-top: 100px;
        }
        
        .middle {
            font-size: 12px;
        }
        

    </style>

</head>

<body>
    <div>
        <div class="boxes left"><img src=""></div>
            <div class="boxes right">
                <div class="text-center">
                    Faktura
                </div>
                <div class="number text-center">
                    '.$invoice->invnum.'
                </div>
               <div class="text-right padding middle">
                    <div>ORYGINAŁ</div>
                    <div>Data wystawienia: '.$invoice->date_issue.'</div>
                    <div>Data usługi/wykonania: '.$invoice->date_issue.'</div>
                    <div>Termin zapłaty: '.$invoice->term_payment.'</div>
                </div>
          </div>
    </div>


    <div>
        <div class="boxes padding left middle">
            <div><strong>Nabywca</strong></div>
            <hr>
            <div>'.$customer->company.'</div>
            <div>'.$customer->address.'</div>
            <div>'.$customer->city.'</div>
            <div>'.$customer->nip.'</div>
            <div>'.$customer->regon.'</div>
        </div>
        <div class="boxes padding right middle">
            <div><strong>Sprzedawca</strong></div>
            <hr>
            <div>'.$profile->company.'</div>
            <div>'.$profile->address.'</div>
            <div>'.$profile->city.'</div>
            <div>'.$profile->nip.'</div>
            <div>'.$profile->regon.'</div>
        </div>
    </div>

    <div class="padding">
        <table>
              <thead>
                <tr>
                  <th>LP</th>
                  <th style="text-align: left;">Nazwa towaru lub usługi</th>
                  <th>Ilość</th>
                  <th>JM</th>
                  <th>Cena netto</th>
                  <th>Wartość netto</th>
                  <th>VAT %</th>
                  <th>VAT</th>
                  <th>Wartość brutto</th>
                </tr>
              </thead>
              <tbody>
              
              ';

        $i = 1;

        foreach ($services as $service) {
            $tax = $service->tax*100;
            $html .='
                <tr>
                  <td>'.$i++.'</td>
                  <td style="text-align: left;">'.$service->service.'</td>
                  <td>'.$service->quantity.'</td>
                  <td>'.$service->unit.'</td>
                  <td>'.$service->net.'</td>
                  <td>'.$service->netv.'</td>
                  <td>'.$tax.'%</td>
                  <td>'.$service->taxv.'</td>
                  <td>'.$service->gross.'</td>
                </tr>
                
                
    ';
        }



        $html .= '
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5" style="text-align: right;">Razem:</td>
                  <td class="border-cell">'.$invoice->net_value.'</td>
                  <td class="border-cell"></td>
                  <td class="border-cell">'.$invoice->tax_value.'</td>
                  <td class="border-cell">'.$invoice->gross_value.'</td>
                </tr>
              </tfoot>
          </table>
    </div>
    <div class="padding middle">
        <div>Do zapłaty: '.$invoice->gross_value.' zł</div>
        <div>Słownie: '.$invoice->inwords.'</div>
        <div>Sposób płatności: '.$invoice->payment.'</div>
        <div>Nr konta: </div>
    </div>

    <div>
        <div class="boxes left text-center sign">
            <hr>
            Osoba uprawniona do otrzymania faktury
        </div>
        <div class="boxes right text-center sign">
            <hr>
            Osoba upoważniona do wystawiania faktur
                <div><strong>'.$profile->name.' '.$profile->surname.'</strong></div>
        </div>
    </div>
</body>';

        $mpdf->SetHTMLFooter('
<hr>
<table width="100%" style="vertical-align: bottom; 
    font-size: 8pt; color: #000000; border: 0; ">
    <tr>
        <td width="33%" style="border: 0;">{DATE j-m-Y}</td>
        <td width="33%" align="center" style="border: 0;">Strona {PAGENO} z {nbpg}</td>
        <td width="33%" style="text-align: right; border: 0;">tel./fax <br> kontakt@firma.pl</td>
    </tr>
</table>');

        $mpdf->WriteHTML($html);
        $mpdf->Output();

        return true;
    }
    catch(\Mpdf\MpdfException $e)
    {
        echo $e->getMessage();

        return false;
    }
}
