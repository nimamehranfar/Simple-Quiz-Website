<?php
if (isset($_POST['action'])) {
    $expire = time() -3600;
    setcookie("name", "1", $expire);
    setcookie("signedin", "1", $expire);
    setcookie("points", "0", $expire);
    setcookie("level", "0", $expire);
    setcookie("wronge_answers", "0", $expire);
    header('Location: index.php');
}elseif (isset($_POST['reload'])){
    header('Location: quiz.php');
}
?>

<html>

<style>
    .reload, .submit1{
        width: 10em !important;
        margin: 1em;
    }
    .form11{
        display: flex;
        align-items: center !important;
        justify-content: center;
        direction: ltr;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">


<form class="form11" action='header.php' method='post'>
    <input type='submit' class="btn btn-primary submit1" name='action' value='Sign Out'><br>
    <input type='submit' class="btn btn-primary reload" name='reload' value='Reload'><br>
</form><br>
</html>
