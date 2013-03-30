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
	//login stuff ---------------
	include("login.php");

	// RESET PASSWORD ------------------------------------------------
	if(isset($_POST['resetPassword']))
	{
		if($_POST['email'] == "" && $_POST['username'] == "")
		{
			$errorMsg[] = "You Must Enter Your Email or Username To Continue";
		}
		else
		{
			$sendIt = false;
			if($_POST['email'] == "")
			{
				//CHECK TO SEE IF THAT PERSON EVEN EXCISTS
				$sql = "SELECT fldUsername FROM tblUsers WHERE fldUsername='" . $_POST['username'] . "'";

				$temp = mysql_query($sql, $connectID);
				$found = false;

				while($userNames = mysql_fetch_array($temp))
				{
					if($userNames[0] == $_POST["username"])
					{
						$found = true;
					}
				}
				if(!$found)
				{
					$errorMsg[] = "The Username You Entered Does Not Excist In Our Database.";
				}

				//Craete THE NEW PASSWORD
				$string = "";
				for($i=1; $i<=8; $i++)
				{
					$string .= rand(0,9);
				}

				$sql101 = "SELECT fldEmail FROM tblUsers WHERE fldUsername='" . $_POST['username'] . "'";
				$temp101 = mysql_query($sql101, $connectID);
				$row101 = mysql_fetch_array($temp101);
				$emailAddress = $row101[0];
	
				if(!$errorMsg)
				{
					$sql = "UPDATE tblUsers SET fldPassword='" . md5($string) . "' WHERE fldUsername='" . $_POST['username'] . "'";
					if(mysql_query($sql, $connectID))
					{
						$sendIt = true;
						$sql = "SELECT fldEmail FROM tblUsers WHERE fldUsername='" . $_POST['username'] . "'";
						$temp = mysql_query($sql, $connectID);
						$row = mysql_fetch_array($temp);
						$method = "A";	
					}
					else
					{
						$errorMsg[] = "Failed To Update Password, Please Try Again.";
					}
				}			
			}
			else
			{
				//CHECK TO SEE IF THAT PERSON EVEN EXCISTS
				$sql = "SELECT fldEmail FROM tblUsers WHERE fldEmail='" . $_POST['email'] . "'";
				$temp = mysql_query($sql, $connectID);
				$found = false;
				while($userNames = mysql_fetch_array($temp))
				{
					if($userNames[0] == $_POST["email"])
					{
						$found = true;	
					}
				}

				if(!$found)
				{
					$errorMsg[] = "The Email You Entered Does Not Excist In Our Database.";
				}

				//CREATE THE NEW PASSWORD
				$string = "";
				for($i=1; $i<=8; $i++)
				{
					$string .= rand(0,9);
				}

				$emailAddress = $_POST['email'];

				if(!$errorMsg)
				{
					$sql = "UPDATE tblUsers SET fldPassword='" . md5($string) . "' WHERE fldEmail='" . $_POST['email'] . "'";
					if(mysql_query($sql, $connectID))
					{
						$sendIt = true;
						$method = "B";
					}
					else
					{
						$errorMsg[] = "Failed To Update Password, Please Try Again.";
					}
				}
				
			}

			/* @@@@@@@@@@@@@@@@@@ MAIL SCRIPING FOR PASSWORD RECOVERY @@@@@@@@@@@@@@@@@@@@*/
			if(!$errorMsg)
			{
				$subject = "New Password For Caked.com"; 
				$message = "We Have Received a Request To Change Your Password\n";
				$message .= "Because We're Totally Awesome and Care About Your Security On The Web,\n";
				$message .= "We Only Store an Irreversible Encrypted Version Of Your Password.\n";
				$message .= "In Other Words, We Dont Know Your Password and Can Only Create A New One For You.\n";
				$message .= "If You Did Not Request a New Password, Then Please Contact Us. \n";
				$message .= "This Could Mean Someone Has Attempted To Gain Access To Your Account.\n";
				$message .= "Your Old Password Has Been Placed In a Metal Box and Detonated With C4.\n";
				$message .= "Your New Password Is: " . $string;

				if($method == "A")
				{
					$sent = mail($row[0], $subject, $message);
				}
				elseif($method == "B")
				{
					$emailAddress = $_POST['email'];
					$sent = mail($emailAddress, $subject, $message);
				}
				
				if($sent)
				{
					$succMsg[] = "An Email Containing Your New Password Has Been Sent to " . $_POST['email'] . " email account.";
				}
				else
				{
					$errorMsg[] = "A Email Error Occured! Please Contact The Administrator!";
				}
			}
		}
	}

	// SIGNUP STUFF ------------------------------------------------
	$userPassed = false;
	if(isset($_POST['submitSignup']))
	{
		//default variables
		$dateJoin = date("o-m-j");
		$adminLevel = 0;

		//CHECK USER INFORMATION
		include("checkUser.php");
		if(!$errorMsg)
		{
			//INSERT CORRECT DATA INTO DATA BASE
			$sql = "INSERT INTO tblUsers SET ";
			$sql .= "fldUsername='" . $_POST['username'] . "', ";
			$sql .= "fldFName='" . $_POST['fName'] . "', ";
			$sql .= "fldLName='" . $_POST['lName'] . "', ";
			$sql .= "fldPassword='" . md5($_POST['password']) . "', ";
			$sql .= "fldEmail='" . $_POST['email'] . "', ";
			$sql .= "fldAdminLevel='" . $adminLevel . "', ";
			$sql .= "fldDateJoin='" . $dateJoin . "'";

			if(!mysql_query($sql,$connectID))
			{
				$errorMsg[] = "Something Went Wrong Please Try Again";
			}
			
			/* @@@@@@@@@@@@@@@@@@ MAIL SCRIPING @@@@@@@@@@@@@@@@@@@@*/

			$subject = "Welcome To Caked.com! - CONFIRMATION MESSAGE";         
			$message = "Thanks for joining CAKED \n";
			$message .= "This is a automatically generated message. DO NOT REPLY\n";
			$message .= "First Name: " . $_POST['fName'] . "\n";
			$message .= "Last Name: " . $_POST['$lName'] . "\n";
			$message .= "Date Join: " . date("o-m-d") . "\n";
			$message .= "Username: " . $_POST['$username'] . "\n";

			$message .= $_POST['PHP_SELF'] . "?checkCode=" . md5($username) . "&showMessage=true";

			$sent = mail($_POST['$email'], $subject, $message);
			if($sent)
			{
				$errorMsg[] = "An email confirmation has been sent to " . $_POST['email'] . ", please check you mail to complete the registration.";
			}
			else
			{
				$errorMsg[] = "A Email Error Occured! Please Contact The Administrator!";
				// ---------------------------------
				//----------------------------------// ---------------------------------
				//----------------------------------// ---------------------------------
				//----------------------------------
			// ----------------------- NNEEEEED TO REMOOVE UUUSSSER INFORMATION!!!!!!!! 
				//-------------------------------------------------------------------
				//----------------------------------// ---------------------------------
				//----------------------------------// ---------------------------------
				//----------------------------------// ---------------------------------
				//----------------------------------// ---------------------------------
				//----------------------------------// ---------------------------------

			}		  		
		}
	}

	/* @@@@@@@@@@@@@@@@@@@@@@@@ CONFIRMATION SCRIPTING @@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
	$userConfirmed = false;
	if(isset($_GET['showMessage']))
	{
		$sql = "SELECT fldUsername, fldFName, fldLName, fldEmail FROM tblUsers";
		$temp = mysql_query($sql, $connectID);
		while($row = mysql_fetch_array($temp))
		{
			/*
			echo "MD5: " . md5($row[0]);
			echo "</br>";
			echo "NORMAL: " . $_GET['checkCode'];
			echo "<hr>";
			*/
			if(md5($row[0]) == $_GET['checkCode'])
			{
				//UPDATE ADMIN LEVEL
				$sql2 = "UPDATE tblUsers SET fldAdminLevel='1' WHERE fldUsername='" . $row[0] . "'";
				$temp2 = mysql_query($sql2, $connectID);
				$_SESSION['username'] = $row[0];
		    	$_SESSION['fName'] = $row[1];
		    	$_SESSION['lName'] = $row[2];
		    	$_SESSION['email'] = $row[3];
		    	$_SESSION['loggedIn'] = true;
		    	$userConfirmed = true;
		    	$userPassed = true;
		    	$errorMsg[] = "You Have Been Confirmed, You Can Now Start Using Caked.com";
			}
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Anders D Melen" />
	<meta name="description" content="Caked Snowboards - Get Gear, Join The Contest, GetWitIt" />
	<META NAME="Title" CONTENT="Caked Snowboards - Signup">
	<meta name="keywords" content="snow, snowboarding, skate, skating, riding, skateboarding, caked, get wit it,  getwitit, contest, raffle, Dave, Tafur" />
	<link rel="stylesheet" href="mystyle.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="button.css" type="text/css" media="screen" />
	<link rel='stylesheet' href='development-bundle/themes/base/jquery.ui.all.css'>
	<?php
		include("jquery.php");
	?>
	<head>
	</head> 

  

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
		<div class='postDiv'>
			<h1>Sign Up</h1>
			<div style='border: 1px solid black; float: left; width: 60%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>Welcome to Caked.com, you can do many things on caked without signing up like check out contests and gear in our store. If you want to be part of the action, like voting for contest entries, submitting an entry yourself, purchasing Caked gear, and much more then you have to sign up. Signing up is quick, easy and free, it only requires a valid and unique email address that hasn't already been registered. Choose a username (visible to all), password, first and last name, and your email and we will send you a verification email. Click the link in the email to be confirmed. You will be welcomed to the Caked community!</div>
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
  
  				echo "<div style='border: 1px solid black; float: left; width: 29%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					echo "<form action='signup.php' method='post' class='noMargin'>
							<table>
								<tr>
									<td>
										<label>Username</label>
										</br>
										<label>Password</label>
										</br>
										<label>Re-Type Password</label>
										</br>
										<label>Email</label>
										</br>
										<label>First Name</label>
										</br>
										<label>Last Name</label>
									</td>
									<td>
										<input type='text' size='15' name='username' id='username' value='";
										if(isset($_POST['username']))
										{
											echo $_POST['username'];
										}
										echo "'/>
										</br>
										<input type='password' size='15' name='password' id='password' value=''/>
										</br>
										<input type='password' size='15' name='password2' id='password2' value=''/>
										</br>
										<input type='text' size='20' name='email' id='email' value='";
										if(isset($_POST['email']))
										{
											echo $_POST['email'];
										}
										echo "'/>
										</br>
										<input type='text' size='15' name='fName' id='fName' value='";
										if(isset($_POST['fName']))
										{
											echo $_POST['fName'];
										}
										echo "'/>
										</br>
										<input type='text' size='15' name='lName' id='lName' value='";
										if(isset($_POST['lName']))
										{
											echo $_POST['lName'];
										}
										echo "'/>
									</br>
									</td>
								</tr>	
								<tr>
									<td colspan='2'>
										<input type='submit' value='Sign Up' name='submitSignup' id='submitSignup'/>
									</td>
								</tr>		
							</table>	
						</form>
					</div>
					<div style='clear: both;'></div>
			</div>";

			// -------------- FORGOT PASSWORD -------------------

			echo "<div class='postDiv'>
			<h1>Reset Password</h1>
			<div style='border: 1px solid black; float: left; width: 60%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>Forgot your password? No Worries, fill in your email address or your Caked username you sign in with and we will send you an email containing your new password. This may take up to several minutes to process, if you don't receive an email within ten minutes, please try again. If you Continue to have trouble contact us via the <a href='contact.php'>contact page</a></div>";
  
  				echo "<div style='border: 1px solid black; float: left; width: 29%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					echo "<form action='signup.php' method='post' class='noMargin'>
							<table>
								<tr>
									<td>
										<label>Username</label>
										</br>
										<label>Email</label>
										</br>
									</td>
									<td>
										<input type='text' size='15' name='username' id='username' value='";
										if(isset($_POST['username']))
										{
											echo $_POST['username'];
										}
										echo "'/>
										</br>
										<input type='text' size='15' name='email' id='email' value='";
										if(isset($_POST['email']))
										{
											echo $_POST['email'];
										}
										echo "'/>
										</br>
									</td>
								</tr>	
								<tr>
									<td colspan='2'>
										<input type='submit' value='Reset Password' name='resetPassword' id='resetPassword'/>
									</td>
								</tr>		
							</table>	
						</form>
					</div>
					<div style='clear: both;'></div>
				</div>
			</div>";	
	?>
	<!-- --------------- END BODY DIV ----------- -->

	<!-- ------------- FOOTER DIV --------- -->
<div id='footerDiv'>
		<center>
		Site Created By: ADM Designs &copy; 2012 | For More Information Visit My Page at <a href='http://www.uvm.edu/~amelen/cs142/assign5/index.php'>ADM Web Designs</a>
		</center>	
	</div>

	
</body>
</html>