<?php
	if(!session_start())
	{
		session_start();
	}
	include("db.inc");
	//include("connect.inc");
	//google tracking
	include("googleTrack.php");
	$errorMsg = array();
	$succMsg = array();
	//INCLUDE LOGIN SCRIPTING
	include("login.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Anders D Melen" />
	<meta name="description" content="Caked Snowboards - Get Gear, Join The Contest, GetWitIt" />
	<META NAME="Title" CONTENT="Caked Snowboards - About Caked">
	<meta name="keywords" content="snow, snowboarding, skate, skating, riding, skateboarding, caked, get wit it,  getwitit, contest, raffle, Dave, Tafur" />
	<link rel="stylesheet" href="mystyle.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="button.css" type="text/css" media="screen" />
	<link rel='stylesheet' href='development-bundle/themes/base/jquery.ui.all.css'>
	<link rel='stylesheet' href='development-bundle/themes/base/jquery.ui.all.css'>
	<?php
		include("jquery.php");
	?>
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
		<?php
			if($errorMsg)
	        {
	        	/*------- login STUFF --------------*/
	        	echo "<div id='hideMe' class='errorDiv' style='display: none;'>";
	        	echo "<ul>\n";
				foreach($errorMsg as $row)
				{
					echo "<li id='killMe'>" . $row . "</li>\n";
				}
				echo "</ul>\n";
				echo "<span style='padding:5px; border: 1px dashed black; border-radius: 5px, 5px, 5px, 5px; margin:0px; margin-left: 400px; font-size: 10px; color: black;'>Click Anywhere To Clear Notifications</span>";
				echo "</div>";
	        }
			if($succMsg)
			{
				echo "<div id='hideMe' class='succDiv' style='display: none;'>";
				echo "<ul>";
				foreach($succMsg as $row)
				{
					echo "<li>" . $row . "</li>\n";
				}
				echo "</ul>\n";
				echo "<span style='padding:5px; border: 1px dashed black; border-radius: 5px, 5px, 5px, 5px; margin:0px; margin-left: 400px; font-size: 10px; color: black;'>Click Anywhere To Clear Notifications</span>";
				echo "</div>";
			}  

		// -------------------- LOGIN / WELCOME DIV! --------------------------------
		include("loginDiv.php");
        
        	echo "<div class='postDiv'>
			<h1>Online Shop</h1>
			<p>Welcome to the caked online store. Here you can purchase caked and other products via a secure paypal or credit card connection. You dont have a sign up to purchase anything, its simple, just click the buy it now button and follow the paypal steps and we'll ship your item right away! <a href='contact.php'>Contact</a> us if you have any questions before pruchasing</p>
			</div>";
			$sql = "SELECT fldName, fldQuantity, fldPrice, fldDescription, fldImage, fldBuyNow FROM tblShop ORDER BY pkItemID DESC";
			$temp = mysql_query($sql, $connectID);
			while($row = mysql_fetch_array($temp))
			{

				echo "<div class='postDiv'>";
						//IMAGE DIV FLOAT LEFT
						echo "<div style='border: 1px solid black; float: left; width: 31%; margin: 10px; margin-right: 0px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
							<a href='../uploads/shopImages/" . $row[4] . "'><img src='../uploads/shopImages/" . $row[4] . "' alt='" . $row[0] . "' width='250px' height='200px'/></a>
						</div>";
						// DESCRIPTION DIV FLOAT RIGHT
						echo "<div style='border: 1px solid black; float: right; width: 60%; margin: 10px; margin-left: 0px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
							<span style='float:right;'>" . $row[5] . "</span>
							<h2>" . $row[0] . "</h2>
							<h3>Price: $" . $row[2] . "</h3>
							<h4>Quantity: " . $row[1] . " in stock</h4>
							<p>
								" . $row[3] . "
							</p>";
						echo "</div>
						<div style='clear:both;'></div>
					</div>";
			}
		?>
	</div>

	<!-- ------------- FOOTER DIV --------- -->
	<div id='footerDiv'>
		<center>
		Site Created By: ADM Designs &copy; 2012 | For More Information Visit My Page at <a href='http://www.uvm.edu/~amelen/cs142/assign5/index.php'>ADM Web Designs</a>
		</center>	
	</div>


	
</body>
</html>