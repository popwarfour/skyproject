<?php

include("db.inc");
$sql = "SELECT * FROM tblUsers";
$temp = mysql_query($sql, $connectID);
while($row = mysql_fetch_array($temp))
{
	echo $row[0];
	echo "</br>";
}
?>