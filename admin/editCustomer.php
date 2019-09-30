<?php

use App\Customer;

include("../includes/header.php");

$message = $session->get('success');
$customer = Customer::findById($_GET['id']);

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

        $session->flash('success', "Klient zaktualizowany !");

        redirect($_GET['id']);
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
                    <?php if ($customer->has('name')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('name');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Nazwisko:</label>
                        <input class="form-control" name="surname" value="<?php echo $customer->surname; ?>" type="text">
                    </div>
                    <?php if ($customer->has('surname')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('surname');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Firma:</label>
                        <input class="form-control" name="company" value="<?php echo $customer->company; ?>" type="text">
                    </div>
                    <?php if ($customer->has('company')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('company');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Adres:</label>
                        <input class="form-control" name="address" value="<?php echo $customer->address; ?>" type="text">
                    </div>
                    <?php if ($customer->has('address')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('address');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Miasto:</label>
                        <input class="form-control" name="city" value="<?php echo $customer->city; ?>" type="text">
                    </div>
                    <?php if ($customer->has('city')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('city');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>NIP:</label>
                        <input class="form-control" name="nip" value="<?php echo $customer->nip; ?>" type="text">
                    </div>
                    <?php if ($customer->has('nip')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('nip');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>REGON:</label>
                        <input class="form-control" name="regon" value="<?php echo $customer->regon; ?>" type="text">
                    </div>
                    <?php if ($customer->has('regon')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $customer->first('regon');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <input class="btn btn-primary" name="submit" type="submit" value="Edytuj klienta">
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