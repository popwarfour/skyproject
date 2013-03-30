<?php
	if(!session_start())
	{
		session_start();
	}
	session_destroy();
	include("db.inc");
	//include("connect.inc");
	//google tracking
	include("googleTrack.php");
	$errorMsg = array();
	$succMsg = array();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Anders D Melen" />
	<meta name="description" content="Caked Snowboards - Get Gear, Join The Contest, GetWitIt" />
	<META NAME="Title" CONTENT="Caked Snowboards - Logout">
	<meta name="keywords" content="snow, snowboarding, skate, skating, riding, skateboarding, caked, get wit it,  getwitit, contest, raffle, Dave, Tafur" />
	<link rel="stylesheet" href="mystyle.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="button.css" type="text/css" media="screen" />
</head>
<body>
	<!-- -------------- FLOATING DIVS --------- -->
	<!-- -------------- MENU DIV ------------- -->
	<?php
		include("menu.php"); 
	?>


	<!-- ------------- HEADER ------------- -->
	<?php
		$sql = "SELECT fldHeaderImage FROM tblGeneral";
		$temp = mysql_query($sql, $connectID);
		$row = mysql_fetch_array($temp);
		$address = "../uploads/header/" . $row[0];

		echo "<div id='headerDiv' style='background-image:url(" . $address . ");'></div>";
	?>



	<!-- ------------ BODY DIV --------- -->
	<div id="bodyDiv">
		<div class='postDiv' class='minHeight'>
			<h2>YOU HAVE BEEN LOGGED OUT</h2>
			<h2>Would Love To See You Back</h2>
			<h2>Watch Out For Upcoming Contests and Giveaways!</h2>
		</div>
	</div>
	<!-- --------------- END BODY DIV ----------- -->

	<!-- ------------- FOOTER DIV --------- -->
<div id='footerDiv' style='position: absolute; bottom: 0px; left: 0px;'>
		<center>
		Site Created By: ADM Designs &copy; 2012 | For More Information Visit My Page at <a href='http://www.uvm.edu/~amelen/cs142/assign5/index.php'>ADM Web Designs</a>
		</center>	
	</div>

	
</body>
</html>