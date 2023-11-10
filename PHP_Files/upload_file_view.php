<?php
function showFile($fileName)
{
$file = fopen($fileName, "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
while(!feof($file))
{
$line=fgets($file);
 $line = str_replace ("&", "&amp;",$line);
 $line = str_replace ("<", "&lt;", $line);
 $line = str_replace (">", "&gt;", $line);

 echo $line . "&#13;&#10;";
}
fclose($file);
}


if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "text/plain")
|| ($_FILES["file"]["type"] == "text/html")
)
&& ($_FILES["file"]["size"] < 2000000))
{
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
}
else
{
echo "Upload: " . $_FILES["file"]["name"] . "<br />";
echo "Type: " . $_FILES["file"]["type"] . "<br />";
echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
if (file_exists("upload/" . $_FILES["file"]["name"]))
{
echo $_FILES["file"]["name"] . " already exists. ";
}
else
{
move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
}
if (($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
	echo "<br><img src=\""."upload/" . $_FILES["file"]["name"]."\" alt=\"uploaded image\"/>";
if (($_FILES["file"]["type"] == "text/plain")
|| ($_FILES["file"]["type"] == "text/html"))
	{
	echo "<br><textarea rows=\"10\" cols=\"80\">";
	showFile("upload/" . $_FILES["file"]["name"]);
	echo "</textarea>";
	}
}
}
else
{
echo "Invalid file";
}



?>