<?php

use App\Customer;

include("../includes/header.php");

$customers = Customer::findAllCustomers($profile->id);

$message = $session->get('success');

?>

    <body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("../includes/navigation.php");?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dodaj fakturę sprzedaży</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <form method="POST" action="/admin/invoice" target="_blank" onSubmit="setTimeout(function(){
    window.location.reload();
},500);">


                    <div class="form-group">
                        <label>Klient:</label>
                        <select class="form-control" name="customer">
                            <?php foreach ($customers as $customer) :?>
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
                        <label>Sposób płatności:</label>
                        <select class="form-control" name="payment">
                            <option value="cash">Gotówka</option>
                            <option value="card">Płatność kartą</option>
                            <option value="7">Przelew - 7 dni</option>
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
                                        <select class="form-control" name="jm" id="">
                                            <option value="szt">szt</option>
                                        </select>
                                    </td>
                                    <td><input id="net" class="form-control decimal" name="net[]" type="text"></td>
                                    <td>
                                        <input id="netv" class="form-control" type="text" disabled>
                                    </td>
                                    <td><select class="form-control" name="tax" id="">
                                            <option value="0.23">23%</option>
                                        </select></td>
                                    <td><input id="tax" class="form-control" type="text" disabled></td>
                                    <td><input id="gross" class="form-control" type="text" disabled></td>
                                    <td></td>
                                </tr>

                            </tbody>

                        </table>

                        <button type="button" class="btn btn-success" id="add_row" style="margin-bottom: 1.2rem">Dodaj produkt/usługę</button>

                        <div class="form-group">
                            <input class="btn btn-primary" name="submit" type="submit" value="Dodaj fakturę">
                        </div>


            </form>

            <?php if (isset($message)) :?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

        </div>


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- JS scripts -->

<?php include("../includes/scripts.php");?>