<?php

require('dbConnect.php');

$sql="INSERT INTO Persons (FirstName, LastName, Age)
VALUES
('$_POST[firstname]','$_POST[lastname]','$_POST[age]')";

echo "SQL Query: <br/>$sql<br/>";

if (mysqli_query($con,$sql))
{
echo "1 Record added";
}
else
{
echo "Error inserting person: " . mysqli_error($con);
}
mysqli_close($con);
?>