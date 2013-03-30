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
	include ("phpValidate.php");



	function getRealIpAddr()
	{ 
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		//check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		//to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else 
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	} 

	function contains($substring, $string)
	{
        $pos = strpos($string, $substring);
        if($pos === false)
        {
            // string needle NOT found in haystack
            return false;
        }
        else
        {
            // string needle found in haystack
            return true;
        }
    }

	// -------------------- SUBMIT NEW VOTE -------------------------------
	if(isset($_POST['submitEntryVote']))
	{
		//CHECK FOR CONTEST START AND FINISH DATES BEFORE ANYTHING
		if(strtotime(date("o-m-d")) < strtotime($_POST['startDate']))
		{
			$errorMsg[] = "The Contest Has Not Officially Started Yet, Check Dates For More Info";
		}
		if(strtotime(date("o-m-d")) > strtotime($_POST['stopDate']))
		{
			$errorMsg[] = "The Contest Has Officially Ended, You Can No Longer Submit An Entry";
		}

		//CHECK IF IP OR USERNAME ALREADY EXCISTS
		$sql = "SELECT fldUsername, fldIP FROM tblContestVote WHERE fldUsername='" . $_SESSION['username'] . "' AND fkContestID='" . $_POST['contestPick'] . "'";
		$checkMe = mysql_query($sql, $connectID);
		$foundMatch = false;
		while($echoMe = mysql_fetch_array($checkMe))
		{
			$foundMatch = true;
		}
		if($foundMatch)
		{
			$errorMsg[] = "You Have Already Voted For This Contest...";
		}

		if(!$errorMsg)
		{
			$sql4 = "INSERT INTO tblContestVote SET fkContestID='" . $_POST['contestPick'] . "', pkEntryID='" . $_POST['entryPick'] . "', fldIP='" . getRealIpAddr() . "', fldUsername='" . $_SESSION['username'] . "'";
			if(mysql_query($sql4, $connectID))
			{
				$succMsg[] = "You Have Voted!";
			}
			else
			{
				$errorMsg[] = "Something Happened, Try Voting Again";
			}
		}

	}



	// ------------------------ SUBMIT NEW ENTRY ----------------------------------
	if(isset($_POST['submitNewEntry']))
	{
		//CHECK FOR CONTEST START AND FINISH DATES BEFORE ANYTHING
		if(strtotime(date("o-m-d")) < strtotime($_POST['startDate']))
		{
			$errorMsg[] = "The Contest Has Not Officially Started Yet, Check Dates For More Info";
		}
		if(strtotime(date("o-m-d")) > strtotime($_POST['stopDate']))
		{
			$errorMsg[] = "The Contest Has Officially Ended, You Can No Longer Submit An Entry";
		}



		//echo $array2[0] . "-" . $array2[1] . "-" . $array2[2]; 
		//SANITIZE title
		$_POST['title'] = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
		if(!verifyAlphaNum($_POST['title']) & strlen($_POST['title']) != 0)
		{
			$errorMsg[] = "The Title Contains Illigal Characters (letters, numbers, ?, !)";
		}
		if($_POST['title'] == "")
		{
			$errorMsg[] = "The Title Cannot Be Blank";
		}

		//SANITIZE description
		$_POST['description'] = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
		if(!verifyText($_POST['description']) & strlen($_POST['description']) != 0)
		{
			$errorMsg[] = "The description Contains Illigal Characters (letters, numbers, ?, !)";
		}
		if($_POST['description'] == "")
		{
			$errorMsg[] = "The description Cannot Be Blank";
		}
		if(strlen($_POST['description']) > 250)
		{
			$errorMsg[] = "The description Cannot Be Longer Than 250 Characters";
		}

		//SANITIZE LINK
		$check = explode(".",$_POST['link']);

		//CHECK FOR URL VERSION
		if($check[0] == "www" || $check[0] == "http://www" || $check[0] == "https://www")
		{
			$realLink = explode("=", $_POST['link']); 
			if(strlen($realLink[1]) != 11)
			{
				$tempLink = $realLink[1];
				$realLink = explode("&", $tempLink);
				$finalLink = $realLink[0];
			}
			else
			{
				$finalLink = $realLink[1];
			}
		}
		else
		{
			$realLink = explode("/", $_POST['link']);
			$finalLink = $realLink[3];
		}

		if(strlen($finalLink) != 11)
		{
			$errorMsg[] = "My Senses Are Detecting An Invalid YouTube Link, Remeber Its !NOT! The Embed Just The Link From The Share Button";
		}

		if(!$errorMsg)
		{
			$sql = "INSERT INTO tblContestEntry SET fldName='" . $_POST['title'] . "', fkContestID='" . $_POST['contestPick'] . "', fldUsername='" . $_SESSION['username'] . "', fldDate='" . date("o-m-d") . "', fldDescription='" . $_POST['description'] . "', fldTime='" . date("H:i:s") . "', fldLink='" . $finalLink . "'";

			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "Your Entry Has Been Submitted, Stay Tuned!";
			}
			else
			{
				$errorMsg[] = "Something Happened And Your Entry Was Not Submitted, Please Try Again";
			}
		}

		if(!$errorMsg & $succMsg)
		{
			$_POST['title'] = "";
			$_POST['description'] = "";
		}
	}


	// RETEIVE THE GET DATA FROM THE URL
	$pkEntryID = $_GET['a'];
	$sql2 = "SELECT fkContestID FROM tblContestEntry WHERE pkEntryID='" . $pkEntryID . "'";
	$temp2 = mysql_query($sql2, $connectID);
	$row2 = mysql_fetch_array($temp2);
	$fail = false;
	if($row2[0] == null)
	{
		$errorMsg[] = "You Are Attemping To View An Entry That Does Not Excist!";
		$fail = true;
	}

	if(!$errorMsg)
	{
		$sql = "SELECT fkContestID, fldUsername, fldName, fldDate, fldTime, fldDescription, fldLink FROM tblContestEntry WHERE pkEntryID='" . $pkEntryID . "'";
		$temp = mysql_query($sql, $connectID);
		$entryData = mysql_fetch_array($temp);

		$sql101 = "SELECT fldStartDate, fldEndDate FROM tblContest WHERE pkContestID='" . $entryData[0] . "'";
		$temp101 = mysql_query($sql101, $connectID);
		$contestData = mysql_fetch_array($temp101);

		// NOW I CAN GET ALL THE DATA FROM ENTRYDATA AND CONTESTDATA!
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Anders D Melen" />
	<meta name="description" content="Caked Snowboards - Get Gear, Join The Contest, GetWitIt" />
	<META NAME="Title" CONTENT="Caked Snowboards - Watch Video Entry">
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

			if($fail)
			{
				//WE DID NOT RECEIVE A CORRECT ENTRY ID
				echo "<div class='postDiv'>";
					echo "YOU HAVE SELECTED A ENTRY THAT DOES NOT EXCSIT!";
				echo "</div>";
			}
			else
			{
				//SHOW THE VIDEO WE RECIEVED CORRECT PKID

				//GET THE VOTE COUNT FOR EACH ECHO
				$sql7 = "SELECT count(fldVoteID) AS fldCount FROM tblContestVote WHERE pkEntryID='" . $pkEntryID . "' GROUP BY pkEntryID";
				$getGroupCount = mysql_query($sql7, $connectID);
				$arrayGroupCount = mysql_fetch_array($getGroupCount);
				if($arrayGroupCount[0] == "")
				{
					$arrayGroupCount[0] = 0;
				}


				//select those five by their ID's and display them
				$sql3 = "SELECT fldName, fldDescription, fldLink, pkEntryID, fldUsername, fldDate, fldTime FROM tblContestEntry WHERE pkEntryID='" . $pkEntryID . "'";
				$temp3 = mysql_query($sql3, $connectID);
				$row3 = mysql_fetch_array($temp3);
				echo "<div class='postDiv'>";
					echo "<p style='font-size: 30px; font-weight: bold; padding: 0px; margin: 0px;'>" . $entryData[2] . "</p>";
					echo "<hr>";
					echo "<div style='border: 1px solid black; float: left; width: 69%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					echo "<iframe width='560' height='315' src='http://www.youtube.com/embed/" . $entryData[6] . "' frameborder='0' allowfullscreen></iframe>";
					echo "</div>";
					echo "<div style='border: 1px solid black; float: left; width: 20%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
						echo "Posted By: ";
						echo $entryData[1];
						echo "</br>";
						echo "<p>";
						echo $entryData[5];
						echo "</p>";
						echo "Total Votes: " . $arrayGroupCount[0];
						if($_SESSION['loggedIn'])
						{
							echo "<form style='float: right; padding: 0px; margin: 0px;' action='" . $_POST['PHP_SELF'] . "' method='post'>";
							echo "<input type='hidden' name='entryPick' id='entryPick' value='" . $pkEntryID . "'/>";
							echo "<input type='hidden' name='startDate' id='startDate' value='" . $contestData[0] . "'/>";
							echo "<input type='hidden' name='stopDate' id='stopDate' value='" . $contestData[1] . "'/>";
							echo "<input type='hidden' name='contestPick' id='contestPick' value='" . $entryData[0] . "'/>";
							echo "<input type='submit' class='button' name='submitEntryVote' id='submitEntryVote' value='Vote'/>";
							echo "</form>";
						}
						echo "<div style='clear: both;'></div>";
						echo "<hr>";
						$date = DATE("M j Y", STRTOTIME($entryData[3]));
						$time  = DATE("g:i a", STRTOTIME($entryData[4]));
						echo $date . ", " . $time;
					echo "</div>";
					echo "<div style='clear:both;'></div>";
				echo "</div>";
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