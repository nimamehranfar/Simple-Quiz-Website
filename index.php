<?php

if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '1') {
    header('Location: status.php');

} elseif (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '2'){
    header('Location: quiz.php');
}

if (isset($_POST['teacher'])) {
    if (!empty($_POST['username1']) && !empty($_POST['password1'])) {
        $username = $_POST['username1'];
        $password = $_POST['password1'];
        $con = new mysqli("localhost", "root", "", "my_db");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $sql = "SELECT * FROM teacher WHERE t_name='$username' AND t_password='$password'";
        $result = $con->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $expire = time() + 60 * 60 * 24 * 7;
            setcookie("name", $username, $expire);
            setcookie("signedin", "1", $expire);
            header('Location: status.php');
        } else {
            fail_toast();
        }
        $con->close();
    }
} else if (isset($_POST['student'])) {
    if (!empty($_POST['username2']) && !empty($_POST['password2'])) {
        $username = $_POST['username2'];
        $password = $_POST['password2'];
        $con = new mysqli("localhost", "root", "", "my_db");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $sql = "SELECT * FROM students WHERE s_name='$username' AND s_password='$password'";
        $result = $con->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $expire = time() + 60 * 60 * 24 * 7;
            setcookie("name", $username, $expire);
            setcookie("signedin", "2", $expire);
            setcookie("points", $row['s_points'], $expire);
            setcookie("level", $row['s_level'], $expire);
            setcookie("wrong_answers", $row['s_wrong_answers'], $expire);
            header('Location: quiz.php');
        } else {
            fail_toast();
        }
        $con->close();
    }
}
?>

<html lang="fa" dir="rtl">

<head>

<style>

    * {
        margin: 0px;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        margin: 0px;
        padding: 0px;
        direction: rtl;
        text-align: right;
    }

    body, html {
        height: 100%;
        margin: 0;
    }

    a {
        text-decoration: none;
        font-family: Arial, Helvetica, sans-serif;
    }

    a:active {

    }

    a:visited {
        text-decoration: none;
        color: #000;
    }

    .container {
        width: 100%;
        max-width: 1600px;
        margin: 0px auto;
        display: block;
        background-size: cover;
        background-repeat: no-repeat;
        position: fixed;
        padding-bottom: 30px;
    }

    .clearfix { /* for solving float problem */
        width: 100%;
        clear: both;
    }

    .welcome {
        width: 85%;
        background: #FF0058;
        background: linear-gradient(180deg, #FF0058 19%, rgba(255, 0, 0, 1) 100%);
        padding-bottom: 40px;
        padding-top: 40px;
        display: block;
        height: 80%;
        position: fixed;
        left: 7%;
        top: 11%;
        border-radius: 20px;
        padding: 10rem 10rem;
    }

    .reg-form {
        position: fixed;
        top: 5%;
        right: 18%;
        width: 25%;
        height: 90%;
        padding: 1rem 1rem;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0px 0px 15px 10px #0000004f;
    }

    .reg-form2 {
        position: fixed;
        top: 5%;
        left: 18%;
        width: 25%;
        height: 90%;
        padding: 1rem 1rem;
        border-radius: 15px;
        background: #fff;
        box-shadow: 0px 0px 15px 10px #0000004f;
    }

    .reg-form .title, .reg-form2 .title {
        font-size: 2.8rem;
        font-weight: bold;
        text-align: center;
        color: #ff1919;
        margin-bottom: 15%;
        margin-top: 10%;
    }

    .circle img {
        height: 90px;
        width: 90px;
        margin-bottom: 5%;
        margin-right: calc(50% - 45px);
    }

    .username {
        display: block;
        border: none;
        padding: 0.1rem 0.8rem;
        font-size: 1.5rem;
        border-bottom: 2px solid #989898;
        margin: 0 auto;
        margin-bottom: 5%;
        margin-top: 10%;
        opacity: 50%;
    }

    .password {
        display: block;
        border: none;
        padding: 0.1rem 0.8rem;
        font-size: 1.5rem;
        border-bottom: 2px solid #989898;
        margin: 0 auto;
        opacity: 50%;
    }

    .login {
        display: block;
        width: 90%;
        border: none;
        background: red;
        color: #fff;
        border-radius: 4px;
        font-size: 1.5rem;
        padding: 0.5rem 0;
        margin: 0 auto;
        margin-bottom: 10px;
        margin-top: 15%;
        box-shadow: 0 0 14px 1px #0009;
        cursor: pointer;
    }

    .default-val {
        direction: ltr;
        text-align: left;
        margin: 1rem 0 0 1.1rem;
    }

</style>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="icon" type="img/jpg" href="../img/smallLogo.png" size="16*16"/>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</head>

<body>
<div class="container">
    <?php
    function fail_toast() {
        $toastAlert="<link rel=\"stylesheet\" href=\"dependencies/bootstrap.min.css\">
                        <script src=\"dependencies/jquery.min.js\"></script>
                        <script src=\"dependencies/popper.min.js\"></script>
                        <script src=\"dependencies/bootstrap.min.js\"></script>
                        <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x\" crossorigin=\"anonymous\">

                    
                        <script>
                            function showtoast() {
                                $('.toast').toast('show');
                            }
                        </script>
                    
                        <style>
                            .rounded-2{
                                width: 1.5em;
                                padding-right: 0.5em;                               
                            }
                            .toast1{
                            background-color: pink !important;
                            direction: ltr;
                            text-align: right;
                            position: fixed;
                            top: 0.3em;
                            left:0.3em; 
                            z-index: 999;
                            }
                            
                        </style>
                        <div class=\"toast toast1\" role=\"alert\" aria-live=\"assertive\" aria-atomic=\"true\">
                            <div class=\"toast-header\">
                                <img src=\"img/fail.png\" class=\"rounded-2\" alt=\"...\">
                                <strong class=\"mr-auto\">خطا</strong>
                            </div>
                            <div class=\"toast-body\">
                                نام کاربری یا رمز عبور اشتباه است
                            </div>
                        </div>";
        echo $toastAlert;
        echo "<script>;
                $(document).ready(function(){
                  showtoast();
                });
            </script>"; }

    ?>

    <div class="welcome"></div>
    <div class="reg-form">
        <p class="title">اساتید</p>
        <div class="circle">
            <img src="img/presentation.svg" alt="">
        </div>
        <form action="index.php" method="post">
            <input class="username" name="username1" type="text" placeholder="نام کاربری">
            <input class="password" name="password1" type="password" placeholder="کلمه عبور">
            <input type="submit" class="login" name="teacher" value="ورود"/>
            <p class="default-val">default username: admin</p>
            <p class="default-val">default password: admin</p>
        </form>
    </div>

    <div class="reg-form2">
        <p class="title">دانش آموزان</p>
        <div class="circle">
            <img src="img/graduated.svg" alt="">
        </div>
        <form action="index.php" method="post">
            <input class="username" name="username2" type="text" placeholder="نام کاربری">
            <input class="password" name="password2" type="password" placeholder="کلمه عبور">
            <input type="submit" class="login" name="student" value="ورود"/>
        </form>
    </div>
</div>

</body>
</html>