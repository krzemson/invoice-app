<?php

use App\Customer;

include("../includes/header.php");

$customers = Customer::findAllCustomers($_SESSION['userId']);

$i= 1;
?>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("../includes/navigation.php");?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Klienci</h1>
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
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Firma</th>
                            <th>Adres</th>
                            <th>Miasto</th>
                            <th>NIP</th>
                            <th>REGON</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($customers as $customer) :?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $customer->name; ?></td>
                            <td><?php echo $customer->surname; ?></td>
                            <td><?php echo $customer->company; ?></td>
                            <td><?php echo $customer->address; ?></td>
                            <td><?php echo $customer->city; ?></td>
                            <td><?php echo $customer->nip; ?></td>
                            <td><?php echo $customer->regon; ?></td>
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
