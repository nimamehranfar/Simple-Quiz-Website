<?php
$con = mysqli_connect("localhost","root","");
if (mysqli_connect_errno())
{
die('Could not connect: ' . mysqli_connect_error()) ;
}

if (mysqli_query($con,"CREATE DATABASE test1"))
{
echo "Database created";
}
else
{
echo "Error creating database: " . mysqli_error($con);
}
mysqli_close($con);
?>