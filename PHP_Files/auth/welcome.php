<html>

<head>

<title>Welcome Page</title>

</head>

<body>

<?php

if(isset($_COOKIE["signedin"])&&$_COOKIE["signedin"]=='1')
{
	echo "<h1>Welcome " . $_COOKIE["username"] . "</h1>";
	echo "<a href='signout.php'>SignOut</a>";
}
else 
	header('Location: signIn.php');
?>
</body>
</html>