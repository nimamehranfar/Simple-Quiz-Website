<?php
$q = intval($_GET['q']);

require("../dbConnect.php");

$sql="SELECT * FROM Persons WHERE personID = '".$q."'";
if(!($result = mysqli_query($con,$sql)))
{
  die("Error select from DB: " . mysqli_error($con));
}
  

echo "<table border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>Age</th>
<th>Hometown</th>
<th>Job</th>
</tr>";

while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['FirstName'] . "</td>";
  echo "<td>" . $row['LastName'] . "</td>";
  echo "<td>" . $row['Age'] . "</td>";
  //echo "<td>" . $row['Hometown'] . "</td>";
  //echo "<td>" . $row['Job'] . "</td>";
  echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?> 