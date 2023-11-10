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
$editname='';
$editpassword='';
$editlevel='';
$editsid='';
$editpoints='';
$editwrongs='';

if (!isset($_COOKIE["signedin"])) {
    header('Location: index.php');
}

foreach ($_POST as $key => $value) {
    if($key=="add"){
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $con = new mysqli("localhost", "root", "", "my_db");
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            $sql="INSERT INTO students(s_name,s_password) VALUES ('$username','$password')";
            if (!mysqli_query($con,$sql))
            {
                die('Error: ' . mysqli_error($con));
            }
            success_toast();
            $con->close();
        }

    }elseif ($key=="edit"){
        if (!empty($_POST['username2']) && !empty($_POST['password2'])) {
            $username2 = $_POST['username2'];
            $password2 = $_POST['password2'];
            $level = $_POST['level'];
            $sid = $_POST['sid2'];
            $con = new mysqli("localhost", "root", "", "my_db");
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            $sql="SELECT * FROM students WHERE s_name='$username2'";
            $result = $con->query($sql);
            if ($result->num_rows == 1 && !$username2==$editname) {
                fail_toast();
            } else {
                $sql = "UPDATE students SET s_name ='$username2' , s_password = '$password2' , s_level= '$level'  WHERE sid= '$sid'";
                if (!mysqli_query($con, $sql)) {
                    die('Error: ' . mysqli_error($con));
                }
                edit_toast();
                $con->close();
            }
        }

    }elseif ($value=="حذف") {
        $con = new mysqli("localhost", "root", "", "my_db");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $sql = "DELETE FROM students WHERE sid=" . $key;
        if (!mysqli_query($con, $sql)) {
            die('Error: ' . mysqli_error($con));
        }
        delete_toast();
        $con->close();

    }elseif ($value=="ویرایش") {
        $con = new mysqli("localhost", "root", "", "my_db");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $sql = "SELECT * FROM students WHERE sid=" . $key;
        $result = $con->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $editname=$row['s_name'];
            $editpassword=$row['s_password'];
            $editlevel=$row['s_level'];
            $editsid=$row['sid'];
            $editwrongs=$row['s_wrong_answers'];
            $editpoints=$row['s_points'];
        }
        $con->close();

        $show_modal="1";
        include("scripts.js.php");
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
        .add{
            min-width: 7em;
            margin-right: 0.5em;
        }
        .delete{
            background-color: red !important;
            border-color: red !important;
            min-width: 7em;
        }
        .delete:hover{
            background-color: darkslategray !important;
            border-color: darkslategray !important;
        }
        .edit{
            background-color: yellowgreen !important;
            border-color: yellowgreen !important;
            min-width: 7em;
        }
        .edit:hover{
            background-color: darkslategray !important;
            border-color: darkslategray !important;
        }
        .flexer{
            display: flex;
        }
        .form1{
            padding-right: 0.5em;
        }
        .form2{
            padding-right: 0.5em;
        }
        .hidden1{
            display: none;
        }
        .username {
            display: block;
            border: none;
            padding: 0.1rem 0.8rem;
            font-size: 1.5rem;
            border-bottom: 2px solid #989898;
            margin: 0 auto;
            margin-bottom: 5%;
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
        .username2 {
            display: block;
            border: none;
            padding: 0.1rem 0.8rem;
            font-size: 1.5rem;
            border-bottom: 2px solid #989898;
            margin: 0 auto;
            margin-bottom: 5%;
            opacity: 50%;
        }

        .password2 {
            display: block;
            border: none;
            padding: 0.1rem 0.8rem;
            font-size: 1.5rem;
            border-bottom: 2px solid #989898;
            margin: 0 auto;
            opacity: 50%;
        }
        .selector{
            display: flex;
            text-align: center;
            align-items: center;
            justify-content: center;
            font-size: large;
            margin-top: 1.5em;
            font-weight: bold;
        }

	
	</style>
	

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Status</title>
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
                                کاربر اضافه شد
                            </div>
                        </div>";
                echo $toastAlert;
                echo "<script>;
                $(document).ready(function(){
                  showtoast();
                });
            </script>"; }

            function delete_toast() {
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
                                <img src=\"img/success.png\" class=\"rounded-2\" alt=\"...\">
                                <strong class=\"mr-auto\">موفقیت آمیز</strong>
                            </div>
                            <div class=\"toast-body\">
                                کاربر حذف شد
                            </div>
                        </div>";
                echo $toastAlert;
                echo "<script>;
                $(document).ready(function(){
                  showtoast();
                });
            </script>"; }

            function edit_toast() {
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
                            background-color: yellowgreen !important;
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
                                کاربر ویرایش شد
                            </div>
                        </div>";
                echo $toastAlert;
                echo "<script>;
                $(document).ready(function(){
                  showtoast();
                });
            </script>"; }

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
                                نام کاربری موجود است
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

                <?php
                $con = new mysqli("localhost", "root", "", "my_db");
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }
                $result = mysqli_query($con,"SELECT * FROM students");
                echo "<table class=\"table table-dark table-hover table-striped\" border='1'>
                <tr>
                <th scope=\"col\">ID</th>
                <th scope=\"col\">نام کاربری</th>
                <th scope=\"col\">کلمه عبور</th>
                <th scope=\"col\">سطح</th>
                <th scope=\"col\">امتیازات</th>
                <th scope=\"col\">درصد موفقیت</th>
                <th scope=\"col\"><button type=\"button\" class=\"btn btn-primary add\" data-bs-toggle=\"modal\" data-bs-target=\"#staticBackdrop\">
                    افزودن
                    </button>
                </th>
                </tr>";

                while($row = mysqli_fetch_array($result))
                 {
                 echo "<tr>";
                 echo "<th scope=\"row\">" . $row['sid'] . "</th>";
                 echo "<td>" . $row['s_name'] . "</td>";
                 echo "<td>" . $row['s_password'] . "</td>";
                 echo "<td>" . $row['s_level'] . "</td>";
                 echo "<td>" . $row['s_points'] . "</td>";
                 if($row['s_wrong_answers']+$row['s_points'] == 0) {
                     echo "<td>" . '0%' . "</td>";
                 } else{
                     echo "<td>" . round($row['s_points'] / ($row['s_wrong_answers'] + $row['s_points'])*100,2) . "%</td>";
                 }
                 echo "<td class='flexer'><form class='form1' action=\"status.php\" method=\"post\">
                    <input type=\"submit\" class=\"btn btn-primary delete\" name=\"".$row['sid'] ."\" value=\"حذف\"/>
                    </form>
                    <form class='form2' action=\"status.php\" method=\"post\">
                    <input type=\"submit\" class=\"btn btn-primary edit\" name=\"".$row['sid'] ."\" value=\"ویرایش\"/>
                    </form>
                    </td>";
                 echo "</tr>";
                 }
                echo "</table>";
                mysqli_close($con);
                ?>
                
            </div>

            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">اضافه کردن دانش آموز</h5>
                        </div>
                        <form action="status.php" method="post">
                        <div class="modal-body">
                            <input class="username" name="username" type="text" placeholder="نام کاربری">
                            <input class="password" name="password" type="password" placeholder="کلمه عبور">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">لغو</button>
                            <input type="submit" class="btn btn-primary login" name="add" value="اضافه کن"/>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel2"> دانش آموز</h5>
                        </div>
                        <form action="status.php" method="post">
                            <div class="modal-body">
                                <input class="username" name="username2" type="text" placeholder="نام کاربری جدید">
                                <input class="hidden1" name="sid2" type="number" value="<?php echo "$editsid" ?>">
                                <input class="password" name="password2" type="password" placeholder="کلمه عبور جدید">
                                <div class="selector">
                                <label for="level">سطح جدید</label>
                                <select id="level" name="level">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">لغو</button>
                                <input type="submit" class="btn btn-primary login" name="edit" value="ویرایش کن"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        
    </body>
</html>