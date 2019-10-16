<?php

use App\InvoiceP;
use App\Customer;
use App\ServiceP;

include("../includes/header.php");

$customers = Customer::findAllCustomers($profile->id);

$message = $session->get('success');
$invoice = InvoiceP::findById($_GET['id']);
$services = $invoice->services();

$counter = 1;

if (isset($_POST['submit'])) {
    $invoice->user_id = $_SESSION['userId'];
    $invoice->date_issue = trim(htmlspecialchars($_POST['dateiss']));
    $invoice->customer_id = trim(htmlspecialchars($_POST['customer']));
    $invoice->date_service = trim(htmlspecialchars($_POST['dateser']));
    $invoice->setPayment($_POST['payment']);
    $invoice->net_value = 0;
    $invoice->tax_value = 0;
    $invoice->gross_value = 0;

    for ($i = 0; $i < count($_POST['service']); $i++) {
        $service = ServiceP::findById($_POST['id'][$i]);

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
    }

    $invoice->inwords = kwotaslownie($invoice->gross_value);
    $invoice->save();

    $session->flash('success', "Faktura sprzedaży została zaktualizowana !");

    redirect($_GET['id']);

}

?>

    <body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("../includes/navigation.php");?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edytuj fakturę zakupu</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <form method="POST" action="">


                <div class="form-group">
                    <label>Klient:</label>
                    <select class="form-control" name="customer">
                        <?php foreach ($customers as $customer) :?>
                            <option value="<?php echo $customer->id ?>" <?php if ($invoice->customer_id == $customer->id) echo "selected" ?> ><?php echo $customer->name . " " . $customer->surname . " - " . $customer->company ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Data wystawienia:</label>
                    <input class="form-control" name="dateiss" type="date" value="<?php echo $invoice->date_issue;?>">
                </div>
                <div class="form-group">
                    <label>Data wykonania usługi:</label>
                    <input class="form-control" name="dateser" type="date" value="<?php echo $invoice->date_service;?>">
                </div>

                <div class="form-group">
                    <label>Sposób płatności:</label>
                    <select class="form-control" name="payment">
                        <option value="cash" <?php if ($invoice->payment == "Gotówka") echo "selected"; ?>>Gotówka</option>
                        <option value="card" <?php if ($invoice->payment == "Płatność kartą") echo "selected"; ?>>Płatność kartą</option>
                        <option value="7" <?php if ($invoice->payment == "Przelew - 7 dni") echo "selected"; ?>>Przelew - 7 dni</option>
                        <option value="14" <?php if ($invoice->payment == "Przelew - 14 dni") echo "selected"; ?>>Przelew - 14 dni</option>
                    </select>
                </div>


                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dynamic-add">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Produkt/usługa</th>
                            <th>Ilość</th>
                            <th>J.M</th>
                            <th>Cena netto</th>
                            <th>Wartość netto</th>
                            <th>VAT</th>
                            <th>Wartość VAT</th>
                            <th>Wartość Brutto</th>
                            <th>Akcja</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($services as $service) :?>
                            <tr>
                                <input type="hidden" value="<?php echo $service->id?>" name="id[]">
                                <td><?php echo "$counter"; ?></td>
                                <td><input class="form-control" name="service[]" type="text" <?php echo "value = '$service->service'"; ?>></td>
                                <td><input id="quantity<?php echo "$counter"; ?>" class="form-control" name="quantity[]" type="text" <?php echo "value = '$service->quantity'"; ?> onkeypress="return isNumber(event)"></td>
                                <td>
                                    <select class="form-control" name="jm" id="">
                                        <option value="szt">szt</option>
                                    </select>
                                </td>
                                <td><input id="net<?php echo "$counter"; ?>" class="form-control decimal" name="net[]" type="text" <?php echo "value = '$service->net'"; ?>></td>
                                <td>
                                    <input id="netv<?php echo "$counter"; ?>" class="form-control" type="text" disabled <?php echo "value = '$service->netv'"; ?>>
                                </td>
                                <td><select class="form-control" name="tax" id="">
                                        <option value="0.23">23%</option>
                                    </select></td>
                                <td><input id="tax<?php echo "$counter"; ?>" class="form-control" type="text" disabled <?php echo "value = '$service->taxv'"; ?>></td>
                                <td><input id="gross<?php echo "$counter"; ?>" class="form-control" type="text" disabled <?php echo "value = '$service->gross'"; ?>></td>
                                <td></td>
                            </tr>

                            <?php $counter++; endforeach;?>

                        </tbody>

                    </table>

                    <!--<button type="button" class="btn btn-success" id="add_row" style="margin-bottom: 1.2rem">Dodaj produkt/usługę</button>-->

                    <div class="form-group">
                        <input class="btn btn-primary" name="submit" type="submit" value="Edytuj fakturę">
                        <a href="/admin/invoices" class="btn btn-warning" style="margin-left: 1rem">Cofnij</a>
                    </div>


            </form>

            <?php if (isset($message)) :?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $message; ?> <a href="/admin/purchase"><b>Wróć</b></a>
                </div>
            <?php endif; ?>

        </div>


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- JS scripts -->

<?php include("../includes/scripts.php");?>