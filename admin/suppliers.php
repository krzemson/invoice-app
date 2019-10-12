<?php

use App\Supplier;

include("../includes/header.php");

$suppliers = Supplier::findAllSuppliers($profile->id);

$i= 1;

if (isset($_POST['submit'])) {
    Supplier::deleteSupplier($_POST['id']);

    redirect('/admin/suppliers');
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
                <h1 class="page-header">Dostawcy</h1>
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
                            <th>Firma</th>
                            <th>Adres</th>
                            <th>Miasto</th>
                            <th>NIP</th>
                            <th>REGON</th>
                            <th class="text-center">Edytuj</th>
                            <th class="text-center">Usuń</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($suppliers as $supplier) :?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $supplier->company; ?></td>
                                <td><?php echo $supplier->address; ?></td>
                                <td><?php echo $supplier->city; ?></td>
                                <td><?php echo $supplier->nip; ?></td>
                                <td><?php echo $supplier->regon; ?></td>
                                <td align="center"><a href="supplier/<?php echo $supplier->id; ?>" class="btn btn-primary">Edytuj</a></td>
                                <td align="center">
                                    <form action="" method="post">
                                        <input type="hidden" value="<?php echo $supplier->id; ?>" name="id">
                                        <button name="submit" type="submit" class="btn btn-danger" onclick="return confirm('Na pewno chcesz usunąć klienta ?');">Usuń</button>
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
