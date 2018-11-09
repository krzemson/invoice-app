<?php
include("../includes/header.php");

if (isset($_POST['submit'])) {
    $profile->name = $_POST['name'];
    $profile->surname = $_POST['surname'];
    $profile->email = $_POST['email'];

    !(empty($_POST['password'])) ? $profile->password = password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    $profile->save();
}

?>

    <body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include("../includes/navigation.php");?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Twój profil</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-lg-4">
                <form method="POST">
                    <div class="form-group">
                        <label>Login:</label>
                        <input class="form-control" placeholder="<?php echo $profile->username ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Imię:</label>
                        <input class="form-control" name="name" value="<?php echo $profile->name ?>">
                    </div>
                    <div class="form-group">
                        <label>Nazwisko:</label>
                        <input class="form-control" name="surname" value="<?php echo $profile->surname ?>">
                    </div>
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input class="form-control" name="email" value="<?php echo $profile->email ?>" type="email">
                    </div>

                    <div class="form-group">
                        <label>Hasło:</label>
                        <input class="form-control" name="password" placeholder="Podaj hasło" type="password">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" name="submit" type="submit" value="Edytuj">
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