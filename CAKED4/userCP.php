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

	//include the user edit methods
	include("editUser.php");

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
		// ------------------ CHECK TO SEE IF THE USER IS EVEN LOGGED IN FIRST! -----------------
		if($_SESSION['loggedIn'] = true)
		{
			//RETRIVE THE USERS INFORMATION

		
		
			echo "<div class='postDiv'>
				<h1>User Control Panel</h1>

				<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					Welcome " . $_SESSION['fName'] . " " . $_SESSION['lName'] . ", here you can change your personal settings like your first and last name, password and shipping address. You can also view all your contest entries, votes, and if your lucky, contest winnings!
				</div>";


				// -------------------------------------------
				// -------------- Names ----------------------
				// -------------------------------------------

				echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					<h3>Change First and Last Name</h3>
					<form action='" . $_SERVER["PHP_SELF"] . "' method='post' class='noMargin'>
						<label>First Name</label>
						<input type='text' name='fName' value='" . $_SESSION['fName'] . "'/>
						
						<label>Last Name</label>
						<input type='text' name='lName' value='" . $_SESSION['lName'] . "'/>
						
						<input type='submit' class='button' name='changeName' id='changeName' value='Update Name'/>
					</form>
				</div>";

				// -------------------------------------------
				// -------------- Password -------------------
				// -------------------------------------------

				echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					<h3>Change Your Password</h3>
					<form action='" . $_SERVER["PHP_SELF"] . "' method='post' class='noMargin'>
						<label>Old Password</label>
						<input type='password' name='oldPass' value=''/>
						
						<label>New Password</label>
						<input type='password' name='newPass1' value=''/>
					
						<input type='submit' class='button' name='changePassword' id='changePassword' value='Update Password'/>
						</br>
						<label style='padding-left: 187;'>Re-Type New Password</label>
						<input type='password' name='newPass2' value=''/>
					</form>
				</div>";

				// -------------------------------------------
				// -------------- ADDRESS --------------------
				// -------------------------------------------

				echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					<h3>Change Your Shipping Address</h3>
					<form action='" . $_SERVER["PHP_SELF"] . "' method='post' class='noMargin'>
						<label>Address</label>
						<input type='text' name='address' value='" . $_SESSION['address'] . "'/>
						
						<label>City</label>
						<input type='text' name='city' value='" . $_SESSION['city'] . "'/>
						
						<label>State</label>
						<input type='text' name='state' value='" . $_SESSION['state'] . "'/>
						</br>
						<label>Zip</label>
						<input type='text' name='zip' value='" . $_SESSION['zip'] . "'/>
						
						<label>Country</label>
						<input type='text' name='country' value='" . $_SESSION['country'] . "'/>
						
						
						<input type='submit' class='button' name='changeAddress' id='changeAddress' value='Update Address'/>
					</form>
				</div>";

				// -------------------------------------------
				// -------------- ENTRIES --------------------
				// -------------------------------------------

				echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					<h3>My Contest Entries (NOT WORKING!)</h3>
					<form action='" . $_SERVER["PHP_SELF"] . "' method='post' class='noMargin'>
						<label>First Name</label>
						<input type='text' value='fname'/>
						</br>
						<label>Last Name</label>
						<input type='text' value='lname'/>
						</br>
						<input type='submit' class='button' name='changeEntries' id='changeEntries' value='Update Name'/>
					</form>
				</div>";

				// -------------------------------------------
				// -------------- VOTES ----------------------
				// -------------------------------------------

				echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					<h3>My Contest Votes (NOT WORKING!)</h3>
					<form action='" . $_SERVER["PHP_SELF"] . "' method='post' class='noMargin'>
						<label>First Name</label>
						<input type='text' value='fname'/>
						</br>
						<label>Last Name</label>
						<input type='text' value='lname'/>
						</br>
						<input type='submit' class='button' name='changeVotes' id='changeVotes' value='Update Name'/>
					</form>
				</div>";

				// -------------------------------------------
				// -------------- WINNINGS -------------------
				// -------------------------------------------

				echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					<h3>My Contest Winnings (NOT WORKING!)</h3>
					<form action='" . $_SERVER["PHP_SELF"] . "' method='post' class='noMargin'>
						<label>First Name</label>
						<input type='text' value='fname'/>
						</br>
						<label>Last Name</label>
						<input type='text' value='lname'/>
						</br>
						<input type='submit' class='button' name='changeWinnings' id='changeWinnings' value='Update Name'/>
					</form>
				</div>";

				echo "</div>
			</div>";
		}  
		else
		{
			// ---------------- USER IS NOT LOGGED IN --------------
			echo "<div class='postDiv'>
				<h1>You Must Be Logged In To View This Page!</h1>
			
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