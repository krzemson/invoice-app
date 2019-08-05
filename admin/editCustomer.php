<?php

use App\Customer;

include("../includes/header.php");

$customer = Customer::findById($_GET['id']);

if (isset($_POST['submit'])) {

    $customer->name = $_POST['name'];
    $customer->surname = $_POST['surname'];
    $customer->company = $_POST['company'];
    $customer->address = $_POST['address'];
    $customer->city = $_POST['city'];
    $customer->nip = $_POST['nip'];
    $customer->regon = $_POST['regon'];

    $customer->save();

    redirect('editCustomer.php?id='.$_GET['id']);

}

?>

    <body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("../includes/navigation.php");?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edytuj klienta</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-4">
                <form method="POST">
                    <div class="form-group">
                        <label>Imię:</label>
                        <input class="form-control" name="name" value="<?php echo $customer->name; ?>" type="text">
                    </div>
                    <div class="form-group">
                        <label>Nazwisko:</label>
                        <input class="form-control" name="surname" value="<?php echo $customer->surname; ?>" type="text">
                    </div>
                    <div class="form-group">
                        <label>Firma:</label>
                        <input class="form-control" name="company" value="<?php echo $customer->company; ?>" type="text">
                    </div>

                    <div class="form-group">
                        <label>Adres:</label>
                        <input class="form-control" name="address" value="<?php echo $customer->address; ?>" type="text">
                    </div>

                    <div class="form-group">
                        <label>Miasto:</label>
                        <input class="form-control" name="city" value="<?php echo $customer->city; ?>" type="text">
                    </div>

                    <div class="form-group">
                        <label>NIP:</label>
                        <input class="form-control" name="nip" value="<?php echo $customer->nip; ?>" type="text">
                    </div>

                    <div class="form-group">
                        <label>REGON:</label>
                        <input class="form-control" name="regon" value="<?php echo $customer->regon; ?>" type="text">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" name="submit" type="submit" value="Edytuj klienta">
                    </div>
                </form>
            </div>

        </div>


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- JS scripts -->

<?php include("../includes/scripts.php");?>