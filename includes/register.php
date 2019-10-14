<?php
require_once('../init.php');

use App\Register;

$session->isCookieValid();

if ($session->isSigned()) {
    redirect('/admin');
} else {

    $message = $session->get('success');

    $register = new Register();

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        $register->setDataRegister($username, $password, $email, $name, $surname);

        if ($register->validate()) {

            $register->register();

            $session->flash('success', "Utworzyłeś konto użytkownika !");

            redirect("/register");

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
<h1 class="text-center">Zarejestruj się</h1>
<div class="container">
    <form method="post" action="">
        <div class="form-group">
            <label for="exampleInputregister">Login</label>
            <input
                type="text"
                class="form-control <?php  echo $register->has('username') ? ' is-invalid' : '' ?>"
                name="username"
                placeholder="Wpisz login"
            >

            <div class="invalid-feedback">
                <?php echo $register->first('username');?>
            </div>

        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Email</label>
            <input
                type="email"
                class="form-control <?php  echo $register->has('email') ? ' is-invalid' : '' ?>"
                name="email"
                placeholder="Wpisz email"
            >

            <div class="invalid-feedback">
                <?php echo $register->first('email');?>
            </div>

        </div>
        <div class="form-group">
            <label for="exampleInputName">Imię</label>
            <input
                type="text"
                class="form-control <?php  echo $register->has('name') ? ' is-invalid' : '' ?>"
                name="name"
                placeholder="Wpisz imię"
            >

            <div class="invalid-feedback">
                <?php echo $register->first('name');?>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputSurname">Nazwisko</label>
            <input
                type="text"
                class="form-control <?php  echo $register->has('surname') ? ' is-invalid' : '' ?>"
                name="surname"
                placeholder="Wpisz nazwisko"
            >

            <div class="invalid-feedback">
                <?php echo $register->first('surname');?>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword">Hasło</label>
            <input
                type="password"
                class="form-control <?php  echo $register->has('password') ? ' is-invalid' : '' ?>"
                name="password"
                placeholder="Wpisz hasło"
            >

            <div class="invalid-feedback">
                <?php echo $register->first('password');?>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="submit">Zarejestruj się</button>
            <a href="/" class="btn btn-warning" style="margin-left: 1rem">Cofnij</a>
        </div>


    </form>




    <?php if (isset($message)):?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 1rem">
            <?php echo $message; ?> <a href="/">Powrót do panelu logowania</a>
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
