<?php

use App\Customer;

include("../includes/header.php");

if (isset($_POST['submit'])) {
    $customer = new Customer();

    $customer->user_id = $_SESSION['userId'];
    $customer->name = $_POST['name'];
    $customer->surname = $_POST['surname'];
    $customer->company = $_POST['company'];
    $customer->address = $_POST['address'];
    $customer->city = $_POST['city'];
    $customer->nip = $_POST['nip'];
    $customer->regon = $_POST['regon'];

    $customer->save();

}

?>

    <body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("../includes/navigation.php");?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dodaj klienta</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-4">
                <form method="POST">
                    <div class="form-group">
                        <label>Imię:</label>
                        <input class="form-control" name="name" placeholder="Wprowadź imię" type="text">
                    </div>
                    <div class="form-group">
                        <label>Nazwisko:</label>
                        <input class="form-control" name="surname" placeholder="Wprowadź nazwisko" type="text">
                    </div>
                    <div class="form-group">
                        <label>Firma:</label>
                        <input class="form-control" name="company" placeholder="Wprowadź nazwę firmy" type="text">
                    </div>

                    <div class="form-group">
                        <label>Adres:</label>
                        <input class="form-control" name="address" placeholder="Wprowadź adres" type="text">
                    </div>

                    <div class="form-group">
                        <label>Miasto:</label>
                        <input class="form-control" name="city" placeholder="Wprowadź miasto" type="text">
                    </div>

                    <div class="form-group">
                        <label>NIP:</label>
                        <input class="form-control" name="nip" placeholder="Wprowadź NIP" type="text">
                    </div>

                    <div class="form-group">
                        <label>REGON:</label>
                        <input class="form-control" name="regon" placeholder="Wprowadź REGON" type="text">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" name="submit" type="submit" value="Dodaj klienta">
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