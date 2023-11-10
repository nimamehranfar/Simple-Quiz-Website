<?php
require("dbConnect.php");

$sql = "CREATE TABLE Persons
(
personID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(personID),
FirstName varchar(15),
LastName varchar(15),
Age int
)";

if (mysqli_query($con,$sql))
{
echo "Table created";
}
else
{
echo "Error creating table: " . mysqli_error($con);
}
mysqli_close($con);
?>