<?php
use App\Customer;

include("../includes/header.php");

$message = $session->get('success');
$customer = new Customer();
if (isset($_POST['submit'])) {
    $customer->user_id = $_SESSION['userId'];
    $customer->name = trim(htmlspecialchars($_POST['name']));
    $customer->surname = trim(htmlspecialchars($_POST['surname']));
    $customer->company = trim(htmlspecialchars($_POST['company']));
    $customer->address = trim(htmlspecialchars($_POST['address']));
    $customer->city = trim(htmlspecialchars($_POST['city']));
    $customer->nip = trim(htmlspecialchars($_POST['nip']));
    $customer->regon = trim(htmlspecialchars($_POST['regon']));

    if ($customer->validate()) {
        $customer->save();

        $session->flash('success', "Klient został dodany !");

        redirect("addCustomer.php");
    }

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
                    <?php if ($customer->has('name')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('name');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Nazwisko:</label>
                        <input class="form-control" name="surname" placeholder="Wprowadź nazwisko" type="text">
                    </div>
                    <?php if ($customer->has('surname')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('surname');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Firma:</label>
                        <input class="form-control" name="company" placeholder="Wprowadź nazwę firmy" type="text">
                    </div>
                    <?php if ($customer->has('company')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('company');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Adres:</label>
                        <input class="form-control" name="address" placeholder="Wprowadź adres" type="text">
                    </div>
                    <?php if ($customer->has('address')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('address');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Miasto:</label>
                        <input class="form-control" name="city" placeholder="Wprowadź miasto" type="text">
                    </div>
                    <?php if ($customer->has('city')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('city');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>NIP:</label>
                        <input class="form-control" name="nip" placeholder="Wprowadź NIP" type="text">
                    </div>
                    <?php if ($customer->has('nip')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('nip');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>REGON:</label>
                        <input class="form-control" name="regon" placeholder="Wprowadź REGON" type="text">
                    </div>
                    <?php if ($customer->has('regon')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('regon');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <input class="btn btn-primary" name="submit" type="submit" value="Dodaj klienta">
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


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- JS scripts -->

<?php include("../includes/scripts.php");?>