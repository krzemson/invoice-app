<?php
use App\supplier;

include("../includes/header.php");

$message = $session->get('success');
$supplier = new supplier();
if (isset($_POST['submit'])) {
    $supplier->user_id = $_SESSION['userId'];
    $supplier->company = trim(htmlspecialchars($_POST['company']));
    $supplier->address = trim(htmlspecialchars($_POST['address']));
    $supplier->city = trim(htmlspecialchars($_POST['city']));
    $supplier->nip = trim(htmlspecialchars($_POST['nip']));
    $supplier->regon = trim(htmlspecialchars($_POST['regon']));

    if ($supplier->validate()) {
        $supplier->save();

        $session->flash('success', "Dostawca został dodany !");

        redirect("supplier");
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
                <h1 class="page-header">Dodaj dostawcę</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-4">
                <form method="POST">
                    <div class="form-group">
                        <label>Firma:</label>
                        <input class="form-control" name="company" placeholder="Wprowadź nazwę firmy" type="text">
                    </div>
                    <?php if ($supplier->has('company')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $supplier->first('company');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Adres:</label>
                        <input class="form-control" name="address" placeholder="Wprowadź adres" type="text">
                    </div>
                    <?php if ($supplier->has('address')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $supplier->first('address');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Miasto:</label>
                        <input class="form-control" name="city" placeholder="Wprowadź miasto" type="text">
                    </div>
                    <?php if ($supplier->has('city')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $supplier->first('city');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>NIP:</label>
                        <input class="form-control" name="nip" placeholder="Wprowadź NIP" type="text">
                    </div>
                    <?php if ($supplier->has('nip')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $supplier->first('nip');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>REGON:</label>
                        <input class="form-control" name="regon" placeholder="Wprowadź REGON" type="text">
                    </div>
                    <?php if ($supplier->has('regon')) : ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $supplier->first('regon');?>
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