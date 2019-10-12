<?php

use App\supplier;

include("../includes/header.php");

$suppliers = supplier::findAllsuppliers($profile->id);

$message = null;

$message2 = $session->get('success');

if(isset($_POST["import"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["uploaded_file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
        $message =  "Plik już istnieje lub nie wybrano żadnego";

    } else {
        if($imageFileType !== "pdf") {
            $message = "Dozwolony format tylko PDF";
        } else {
            if (move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $target_file)) {

                $file = $target_file;

                $command = escapeshellcmd("/Users/krzemson/Desktop/aed/ocr.py $file");
                $output = shell_exec($command);

                $data = json_decode($output);

                unlink($target_file);

                $message = "Zaimportowano fakturę !";

            } else {
                $message =  "Przepraszamy, wystąpił błąd w trakcie wgrywania pliku.";
            }
        }
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
                <h1 class="page-header">Dodaj fakturę zakupu</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <form method="POST" action="/admin/purchases" target="_blank" onSubmit="setTimeout(function(){
    window.location.reload();
},500);">


                <div class="form-group">
                    <label>Dostawca:</label>
                    <select class="form-control" name="supplier">
                        <?php foreach ($suppliers as $supplier) :?>
                            <option value="<?php echo $supplier->id ?>"><?php echo $supplier->company ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Data wystawienia:</label>
                    <input class="form-control" name="dateiss" type="date" <?php if (isset($data->date)) {echo "value = '$data->date'";} ?>>
                </div>
                <div class="form-group">
                    <label>Data wykonania usługi:</label>
                    <input class="form-control" name="dateser" type="date" <?php if (isset($data->date_issue)) {echo "value = '$data->date_issue'";} ?>>
                </div>

                <div class="form-group">
                    <label>Data płatności:</label>
                    <input class="form-control" name="datepay" type="date" <?php if (isset($data->date_payment)) {echo "value = '$data->date_payment'";} ?>>
                </div>

                <div class="form-group">
                    <label>Sposób płatności:</label>
                    <select class="form-control" name="payment">
                        <option value="cash" >Gotówka</option>
                        <option value="card" >Płatność kartą</option>
                        <option value="7" >Przelew - 7 dni</option>
                        <option value="14" >Przelew - 14 dni</option>
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

                        <?php if (isset($data->lines)) { foreach ($data->lines as $line) :?>

                        <tr>
                            <td><?php echo "$line->lp"; ?></td>
                            <td><input class="form-control" name="service[]" type="text" <?php echo "value = '$line->description'"; ?>></td>
                            <td><input id="quantity<?php echo "$line->lp"; ?>" class="form-control" name="quantity[]" type="text" <?php echo "value = '$line->quan'"; ?> onkeypress="return isNumber(event)"></td>
                            <td>
                                <select class="form-control" name="jm" id="">
                                    <option value="szt">szt</option>
                                </select>
                            </td>
                            <td><input id="net<?php echo "$line->lp"; ?>" class="form-control decimal" name="net[]" type="text" <?php echo "value = '$line->netto'"; ?>></td>
                            <td>
                                <input id="netv<?php echo "$line->lp"; ?>" class="form-control" type="text" disabled <?php echo "value = '$line->wnetto'"; ?>>
                            </td>
                            <td><select class="form-control" name="tax" id="">
                                    <option value="0.23">23%</option>
                                </select></td>
                            <td><input id="tax<?php echo "$line->lp"; ?>" class="form-control" type="text" disabled <?php echo "value = '$line->vat'"; ?>></td>
                            <td><input id="gross<?php echo "$line->lp"; ?>" class="form-control" type="text" disabled <?php echo "value = '$line->brutto'"; ?>></td>
                            <td></td>
                        </tr>
                        <?php endforeach; } else {?>
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
                        <?php } ?>
                        </tbody>

                    </table>



                    <button type="button" class="btn btn-success" id="add_row" style="margin-bottom: 1.2rem">Dodaj produkt/usługę</button>

                    <div class="form-group">
                        <input class="btn btn-primary" name="submit" type="submit" value="Dodaj fakturę">
                    </div>


            </form>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-group" style="margin-bottom: 1.2rem">
                          <span class="input-group-btn">
                            <span class="btn btn-warning" onclick="$(this).parent().find('input[type=file]').click();">Wybierz plik faktury zakupowej</span>
                            <input name="uploaded_file" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                          </span>
                    <span class="form-control"></span>

                </div>
                <input class="btn btn-primary" name="import" type="submit" value="Zaimportuj fakturę zakupu">

                <?php if ($message) :?>
                    <div class="alert alert-success alert-dismissible" style="margin-top: 1rem">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

            </form>

            <?php if (isset($message2)) :?>
                <div class="alert alert-success alert-dismissible" style="margin-top: 1rem">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $message2; ?>
                </div>
            <?php endif; ?>

        </div>


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->


<!-- JS scripts -->

<?php include("../includes/scripts.php");?>