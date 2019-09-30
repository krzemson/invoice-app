<?php

use App\Invoice;

include("../includes/header.php");

$invoices = Invoice::findAllInvoices($_SESSION['userId']);

$i= 1;

if (isset($_POST['submit'])) {
    Invoice::deleteInvoice($_POST['id']);

    redirect('invoices');
}

?>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("../includes/navigation.php");?>

    <?php

         ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Faktury Sprzedaży</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nr faktury</th>
                            <th>Klient</th>
                            <th>Płatność</th>
                            <th>Wartość netto</th>
                            <th>Wartość VAT</th>
                            <th>Wartość brutto</th>
                            <th>Termin płatności</th>
                            <th>Data faktury</th>
                            <th>Data usługi</th>
                            <th class="text-center">Edytuj</th>
                            <th class="text-center">Usuń</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($invoices as $invoice) :?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $invoice->invnum; ?></td>
                            <td><?php echo $invoice->customer()->company; ?></td>
                            <td><?php echo $invoice->payment; ?></td>
                            <td><?php echo $invoice->net_value; ?></td>
                            <td><?php echo $invoice->tax_value; ?></td>
                            <td><?php echo $invoice->gross_value; ?></td>
                            <td><?php echo $invoice->term_payment; ?></td>
                            <td><?php echo $invoice->date_issue; ?></td>
                            <td><?php echo $invoice->date_service; ?></td>
                            <td align="center"><a href="invoice/<?php echo $invoice->id; ?>" class="btn btn-primary" target="_blank">Podgląd</a></td>
                            <td align="center">
                                <form action="" method="post">
                                    <input type="hidden" value="<?php echo $invoice->id; ?>" name="id">
                                    <button name="submit" type="submit" class="btn btn-danger" onclick="return confirm('Na pewno chcesz usunąć fakturę ?');">Usuń</button>
                                </form>
                            </td>
                        </tr>
                            <?php $i++;?>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
        </div>


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- JS scripts -->

<?php include("../includes/scripts.php");?>
