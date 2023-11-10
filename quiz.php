<?php


    if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '2') {
        echo " <p class=\"welcome-text float-right\">خوش اومدی</p>
        <p class=\"welcome-text2 float-right\">".$_COOKIE['name']."</p>

        <p class=\"level-text float-right\">سطح شما</p>
        <p class=\"level-text2 float-right\">".$_COOKIE['level']."</p>

        <p class=\"score-text float-right\">امتیاز شما</p>
        <p class=\"score-text2 float-right\">".$_COOKIE['points']."</p>";
        if ($_COOKIE['wrong_answers'] + $_COOKIE['points'] == 0) {
            echo "<p class=\"succes-text float-right\">درصد موفقیت شما</p>
        <p class=\"succes-text2 float-right\">0٪</p>";
        } else {
            echo "<p class=\"succes-text float-right\">درصد موفقیت شما</p>
        <p class=\"succes-text2 float-right\">". round($_COOKIE['points'] / ($_COOKIE['wrong_answers'] + $_COOKIE['points']) * 100, 2)."</p>" ;
        }
    } elseif (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '1') {
        echo " <p class=\"welcome-text float-right\">خوش اومدی</p>
        <p class=\"welcome-text2 float-right\">".$_COOKIE['name']."</p>";
    }

    echo "<style>
        * {
            margin: 0;
            padding: 0;
        }

        .welcome-text {
            display: inline-block;
        }

        .clearfix {
            width: 100%;
            clear: both;
        }

        .float-right {
            float: right;
        }

        .welcome-text, .level-text, .score-text, .succes-text {
            margin-left: 1rem;
        }

        .welcome-text2, .level-text2, .score-text2, .succes-text2 {
            margin-left: 2rem;
            border-left: 1px solid #000;
            padding-left: 0.5rem;
        }



    </style>";




?>

<?php

if (isset($_POST['submit'])) {
    if (isset($_POST['flexRadioDefault'])) {
        $answer = intval($_POST['flexRadioDefault']);
        $numberofimage=$_POST['num1'];
        if($numberofimage==$answer){
            success_toast();
            $con = new mysqli("localhost", "root", "", "my_db");
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '2') {
                $username=$_COOKIE['name'];
            }
            $sql="UPDATE students SET s_points= s_points+1  WHERE s_name= '$username'";
            if (!mysqli_query($con,$sql))
            {
                die('Error: ' . mysqli_error($con));
            }

            $sql = "SELECT * FROM students WHERE s_name='$username'";
            $result = $con->query($sql);
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $expire = time() + 60 * 60 * 24 * 7;
                setcookie("points", $row['s_points'], $expire);
                //header('Location: quiz.php');
            }
            $con->close();
        }
        else{
            fail_toast();
            $con = new mysqli("localhost", "root", "", "my_db");
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '2') {
                $username=$_COOKIE['name'];
            }
            $sql="UPDATE students SET s_wrong_answers= s_wrong_answers+1  WHERE s_name= '$username'";
            if (!mysqli_query($con,$sql))
            {
                die('Error: ' . mysqli_error($con));
            }

            $sql = "SELECT * FROM students WHERE s_name='$username'";
            $result = $con->query($sql);
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $expire = time() + 60 * 60 * 24 * 7;
                setcookie("wrong_answers", $row['s_wrong_answers'], $expire);
                //header('Location: quiz.php');
            }
            $con->close();
        }
        if($_COOKIE['wrong_answers']+$_COOKIE['points']>=10 && round($_COOKIE['points'] / ($_COOKIE['wrong_answers']+$_COOKIE['points'])*100,2)>=90){
            $con = new mysqli("localhost", "root", "", "my_db");
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            if (isset($_COOKIE["signedin"]) && $_COOKIE["signedin"] == '2') {
                $username=$_COOKIE['name'];
            }
            $sql="UPDATE students SET s_level= s_level+1 WHERE s_name= '$username'";
            if (!mysqli_query($con,$sql))
            {
                die('Error: ' . mysqli_error($con));
            }
            $sql = "SELECT * FROM students WHERE s_name='$username'";
            $result = $con->query($sql);
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $expire = time() + 60 * 60 * 24 * 7;
                setcookie("level", $row['s_level'], $expire);
                //header('Location: quiz.php');

            }
            $con->close();
        }

    }
}
?>


<html lang="fa" dir="rtl">
<?php include("header.php"); ?>

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
		}
		.clearfix { /* for solving float problem */
			width: 100%;
			clear: both;
		}
		.welcome{
			width: 85%;
			background: #FF0058;
			background: linear-gradient(180deg, #FF0058 19%, rgba(255,0,0,1) 100%);
			padding-bottom: 40px;
			padding-top: 40px;
			display: block;
			border-radius: 20px;
			padding: 5rem 5rem;
            margin: 2% 7.5% 3% 7.5%;
		}
        .img1{
            max-width: 3em;
        }
        .form-check{
            direction: ltr;
            text-align: left;
        }
        .form-check-label{
            padding: 1em;
            min-width: 11em;
        }
        .hidden1{
            display: none;
        }
	
	</style>
	

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quiz</title>
        <link rel="icon" type="img/jpg"  href="../img/smallLogo.png" size="16*16" />
    <link rel=\"stylesheet\" href="dependencies/bootstrap.min.css" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="dependencies/jquery.min.js"></script>
    <script src="dependencies/popper.min.js"></script>
    <script src="dependencies/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</head>

    <body>
        <div class="container">
            <?php
            function success_toast() {
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
                            background-color: greenyellow !important;
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
                                <img src=\"img/success.png\" class=\"rounded-2\" alt=\"...\">
                                <strong class=\"mr-auto\">موفقیت آمیز</strong>
                            </div>
                            <div class=\"toast-body\">
                            جواب درست
                            </div>
                        </div>";
                echo $toastAlert;
                echo "<script>;
                $(document).ready(function(){
                  showtoast();
                });
            </script>";
            }

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
                                جواب نادرست
                            </div>
                        </div>";
                echo $toastAlert;
                echo "<script>;
                $(document).ready(function(){
                  showtoast();
                });
            </script>"; }

            ?>

            <div class="welcome">

                <p> چند میوه وجود دارد؟</p>


                <?php
                $number_of_img=rand(1,9);
                $i=$number_of_img;
                echo "<div>";
                for ($i; $i >0; $i--) {
                    echo "<img class='img1' src='img/apple.svg'>";
                }
                echo "</div>";

                $answer_number=rand(1,5);
                echo "<form action=\"quiz.php\" method=\"post\">";
                echo "<div class=\"form-check\">";
                $arr=array(5);
                array_push($arr,$number_of_img);

                for ($j=1; $j<6; $j++) {
                        if($j==$answer_number){
                            echo "<label class=\"form-check-label\" for=\"flexRadioDefault".$j."\">
                          <input class=\"form-check-input\" type=\"radio\" name=\"flexRadioDefault\" value=\"".$j."\" id=\"flexRadioDefault".$j."\">
                          ".$number_of_img."
                          </label>";
                        }else {
                            $temp='';

                            do
                            {
                                $temp=rand(1,9);
                            }
                            while (array_search($temp,$arr));
                            array_push($arr,$temp);

                            echo "<label class=\"form-check-label\" for=\"flexRadioDefault" . $j . "\">
                            <input class=\"form-check-input\" type=\"radio\" name=\"flexRadioDefault\" value=\"".$temp."\" id=\"flexRadioDefault".$j."\">
                            ".$temp."
                            </label>";
                        }
                }
                echo "</div>";
                echo "<input class=\"hidden1\" name=\"num1\" type=\"number\" value=\"".$answer_number."\">";
                echo "<input type=\"submit\" class=\"btn btn-primary login\" name=\"submit\" value=\"ثبت\"/>";
                echo "</form>";

                ?>


            </div>
            
        </div>
        
    </body>
</html>