<?php

use App\InvoiceP;

include("../includes/header.php");

$invoices = InvoiceP::findAllInvoices($profile->id);

$i= 1;

if (isset($_POST['submit'])) {
    InvoiceP::deleteInvoice($_POST['id']);

    redirect('purchase');
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
                <h1 class="page-header">Faktury Zakupowe</h1>
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
                            <th class="text-center">Podgląd</th>
                            <th class="text-center">Edytuj</th>
                            <th class="text-center">Usuń</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($invoices as $invoice) :?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $invoice->invnum; ?></td>
                                <td><?php echo $invoice->supplier()->company; ?></td>
                                <td><?php echo $invoice->payment; ?></td>
                                <td><?php echo $invoice->net_value; ?></td>
                                <td><?php echo $invoice->tax_value; ?></td>
                                <td><?php echo $invoice->gross_value; ?></td>
                                <td><?php echo $invoice->term_payment; ?></td>
                                <td><?php echo $invoice->date_issue; ?></td>
                                <td><?php echo $invoice->date_service; ?></td>
                                <td align="center"><a href="purchases/<?php echo $invoice->id; ?>" class="btn btn-primary" target="_blank">Podgląd</a></td>
                                <td align="center"><a href="edit/invoice/<?php echo $invoice->id; ?>" class="btn btn-warning" target="_blank">Edytuj</a></td>
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
