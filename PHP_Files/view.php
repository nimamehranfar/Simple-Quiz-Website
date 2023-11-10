<?php

require('dbConnect.php');

$sql="SELECT * FROM Persons";

echo "SQL Query: <br/>$sql<br/>";

if (($result=mysqli_query($con,$sql)))
{
    echo "<table border='1'>";
    while($row=mysqli_fetch_row($result))
        {
            //print_r($row);
            echo "<tr>";
            echo "<td>" . $row[1] . "</td><td>" . $row[2] . "</td>";
            echo "<tr/>";
        }
    echo "</table>";
}
else
{
echo "Error in selection person: " . mysqli_error($con);
}
mysqli_close($con);
?>