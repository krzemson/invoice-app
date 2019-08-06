<?php
include("../includes/header.php");

$message = $session->get('success');

if (isset($_POST['submit'])) {
    $profile->name = trim(htmlspecialchars($_POST['name']));
    $profile->surname = trim(htmlspecialchars($_POST['surname']));
    $profile->email = trim(htmlspecialchars($_POST['email']));
    $profile->company = trim(htmlspecialchars($_POST['company']));
    $profile->address = trim(htmlspecialchars($_POST['address']));
    $profile->city = trim(htmlspecialchars($_POST['city']));
    $profile->nip = trim(htmlspecialchars($_POST['nip']));
    $profile->regon = trim(htmlspecialchars($_POST['regon']));

    if ($profile->validate()) {
        !(empty($_POST['password'])) ? $profile->password = password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        $profile->save();

        $session->flash('success', "Profil został zaktualizowany !");

        redirect('profile.php');
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
                    <?php if ($profile->has('name')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $profile->first('name');?>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Nazwisko:</label>
                        <input class="form-control" name="surname" value="<?php echo $profile->surname ?>">
                    </div>
                    <?php if ($profile->has('surname')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $profile->first('surname');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>E-mail:</label>
                        <input class="form-control" name="email" value="<?php echo $profile->email ?>" type="email">
                    </div>
                    <?php if ($profile->has('email')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $profile->first('email');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Firma:</label>
                        <input class="form-control" name="company" value="<?php echo $profile->company ?>" type="text">
                    </div>
                    <?php if ($profile->has('company')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $profile->first('company');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Ulica:</label>
                        <input class="form-control" name="address" value="<?php echo $profile->address ?>" type="text">
                    </div>
                    <?php if ($profile->has('address')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $profile->first('address');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Miasto:</label>
                        <input class="form-control" name="city" value="<?php echo $profile->city ?>" type="text">
                    </div>
                    <?php if ($profile->has('city')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $profile->first('city');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>NIP:</label>
                        <input class="form-control" name="nip" value="<?php echo $profile->nip ?>" type="text">
                    </div>
                    <?php if ($profile->has('nip')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $profile->first('nip');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>REGON:</label>
                        <input class="form-control" name="regon" value="<?php echo $profile->regon ?>" type="text">
                    </div>
                    <?php if ($profile->has('regon')): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $profile->first('regon');?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Hasło:</label>
                        <input class="form-control" name="password" placeholder="Podaj hasło" type="password">
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" name="submit" type="submit" value="Edytuj">
                    </div>
                </form>
                <?php if (isset($message)):?>
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