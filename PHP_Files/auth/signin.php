<?php 
//session_start(); 
?>
<html>

<head>

<title>SignIn</title>

</head>

<body>

<?php
/* 
$_SESSION['signed']=1;
$_SESSION['username']="ali";
session_unset();
session_destroy(); 
*/

if(isset($_COOKIE["signedin"])&&$_COOKIE["signedin"]=='1')
	header('Location: welcome.php');

if(isset($_POST['username']) && isset($_POST['password']))
	{
	$username=$_POST['username']; $password=$_POST['password'];
	if(!empty($username) && !empty($password)&&$username=="ali"&&$password=="abc")
		{
			$expire=time()+60*60*24*7;
			setcookie("username", "ali");//, $expire);
			setcookie("signedin", "1");//, $expire);
			header('Location: welcome.php');
		}
	else
		{
		echo 'You must enter a username and password.';
		}
	}
?>

<form action="signIn.php" method="POST">
<br>Usrename: <input type="text" name="username">
<br>Password: <input type="password"name="password">
<br><input type="submit" value="Sign In">
</form>

</body>
</html>