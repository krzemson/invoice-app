<?php

use App\Customer;

include("../includes/header.php");

$customers = Customer::findAllCustomers($profile->id);

?>

    <body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("../includes/navigation.php");?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dodaj fakturę</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <form method="POST" action="invoice.php">


                    <div class="form-group">
                        <label>Klient:</label>
                        <select name="customer">
                            <?php foreach ($customers as $customer):?>

                                <option value="<?php echo $customer->id ?>"><?php echo $customer->name . " " . $customer->surname . " - " . $customer->company ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Data wystawienia:</label>
                        <input class="form-control" name="dateiss" type="date">
                    </div>
                    <div class="form-group">
                        <label>Data wykonania usługi:</label>
                        <input class="form-control" name="dateser" type="date">
                    </div>

                    <div class="form-group">
                        <select name="payment">
                            <option value="14">Przelew - 14 dni</option>
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
                                <tr>
                                    <td>1</td>
                                    <td><input class="form-control" name="service[]" type="text"></td>
                                    <td><input id="quantity" class="form-control" name="quantity[]" type="text" onkeypress="return isNumber(event)" value="1"></td>
                                    <td>
                                        <select name="jm" id="">
                                            <option value="szt">szt</option>
                                        </select>
                                    </td>
                                    <td><input id="net" class="form-control decimal" name="net[]" type="text"></td>
                                    <td>
                                        <input id="netv" class="form-control" name="netvalue[]" type="text" disabled>
                                    </td>
                                    <td><select name="tax" id="">
                                            <option value="0.23">23%</option>
                                        </select></td>
                                    <td><input id="tax" class="form-control" name="taxvalue[]" type="text" disabled></td>
                                    <td><input id="gross" class="form-control" name="gross[]" type="text" disabled></td>
                                    <td></td>
                                </tr>

                            </tbody>

                        </table>

                        <button type="button" class="btn btn-success" id="add_row">Dodaj produkt/usługę</button>

                        <div class="form-group">
                            <input class="btn btn-primary" name="submit" type="submit" value="Dodaj fakturę">
                        </div>


            </form>

        </div>


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- JS scripts -->

<?php include("../includes/scripts.php");?>