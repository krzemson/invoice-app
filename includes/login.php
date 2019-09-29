<?php

use App\Login;

$session->isCookieValid();

if ($session->isSigned()) {
    redirect('/admin');
} else {
    $login = new Login();

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login->setUsernameAndPassword($username, $password);

        if ($login->validate()) {
            if ($obj = $login->verify()) {
                $session->login($obj);
                if (isset($_POST['remember'])) {
                    $session->rememberMe();
                }
                redirect('/admin');
            }
        }
    }
}


?>
<!doctype html>
<html lang="pl">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css"
            integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
            crossorigin="anonymous"
    >

    <title>System Faktur</title>
</head>
<body>
<h1 class="text-center">Zaloguj się</h1>
<div class="container">
        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input
                        type="text"
                        class="form-control <?php  echo $login->has('username') ? ' is-invalid' : '' ?>"
                        name="username"
                        placeholder="Enter username"
                >

                <div class="invalid-feedback">
                    <?php echo $login->first('username');?>
                </div>

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input
                        type="password"
                        class="form-control <?php  echo $login->has('password') ? ' is-invalid' : '' ?>"
                        name="password"
                        placeholder="Password"
                >

                <div class="invalid-feedback">
                    <?php echo $login->first('password');?>
                </div>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Zapamiętaj mnie</label>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Zaloguj się</button>
        </form>




    <?php if ($login->has('verify')) :?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $login->first('verify') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous">

</script>
<script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous">

</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js"
        integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em"
        crossorigin="anonymous">

</script>
</body>
</html>
