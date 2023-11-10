<html>
<body>

<?php
$expire=time()-3600;
setcookie("username", "ali", $expire);
setcookie("signedin", "1", $expire);
header('Location: signin.php');
?>

</body>
</html>