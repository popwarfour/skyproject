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

	if(!isset($_POST['title']))
	{
		$_POST['title'] = "";
	}
	if(!isset($_POST['description']))
	{
		$_POST['description'] = "";
	}
	if(!isset($_POST['link']))
	{
		$_POST['link'] = "";
	}


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
		if($_POST['link'] == "")
		{
			$errorMsg[] = "Youtube Link Cannot Be Blank!";
		}

		if(!$errorMsg)
		{
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
				if(!isset($realLink[3]))
				{
					$realLink[3] = "";
				}
				$finalLink = $realLink[3];
			}

			if(strlen($finalLink) != 11)
			{
				$errorMsg[] = "My Senses Are Detecting An Invalid YouTube Link, Remeber Its <span style='font-size: 20'>NOT</span> The Embed. Just The URL Link, Or The Link From The Share Button";
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
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Anders D Melen" />
	<meta name="description" content="Caked Snowboards - Get Gear, Join The Contest, GetWitIt" />
	<META NAME="Title" CONTENT="Caked Snowboards - Contests">
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
	<!-- -------------- LOGIN DIV ---------- -->
	

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
		?>
		<div class='postDiv'>
			<h1>Contest</h1>
			<p>Contests are places to get noticed and win gear while doing it. Every contest will be different from the last, different prizes and different entries. In general most contests will be for best video or best photo. Win Caked and other prizes just by voting for an entry or step on and enter yourself for a chance to win the real goods! To Submit an entry you must be logged into your caked account.</p>
		</div>
		<?php
			$sql = "SELECT fldTitle, fldStartDate, fldEndDate, fldDescription, fkUsername, pkContestID FROM tblContest ORDER BY pkContestID DESC";

			$temp = mysql_query($sql, $connectID);
			while($row = mysql_fetch_array($temp))
			{
				//------------- TITLE
				echo "<div class='postDiv' style='padding-bottom: 0px;'>";
					echo "<h2>" . $row[0] . "</h2>";
					echo "<hr>";
				//----------- DETAILS
					//TOTAL ENTRIES
					$sql9 = "SELECT count(pkEntryID) AS fldCount FROM tblContestEntry WHERE fkContestID='" . $row[5] . "'";
					$temp9 = mysql_query($sql9, $connectID);
					$row9 = mysql_fetch_array($temp9);
					if($row9[0] == "")
					{
						$row9[0] = 0;
					}
					//TOTAL VOTES
					$sql10 = "SELECT count(fldVoteID) AS fldCount FROM tblContestVote WHERE fkContestID='" . $row[5] . "'";
					$temp10 = mysql_query($sql10, $connectID);
					$row10 = mysql_fetch_array($temp10);
					if($row10[0] == "")
					{
						$row10[0] = 0;
					}
					$contestStartDate = DATE("M j Y", STRTOTIME($row[1]));
					$contestStopDate  = DATE("M j Y", STRTOTIME($row[2]));

					echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
						echo "<p style='margin: 5px; padding: 0px; font-size: 15px; float: left;'>" . $row9[0] . " Total Entries Submitted!</br>";
							echo $row10[0] . " Total Votes!</p>";
						echo "<p style='margin: 5px; padding: 0px; font-size: 15px; float: right;'>Contest Created By " . $row[4] . "</br>";
						echo "Starts <span style='font-weight: bold;'>" . $contestStartDate . "</span>, Ends <span style='font-weight: bold;'>" . $contestStopDate . "</span></p>";
						echo "<div style='clear: both;'></div>";
						echo "<p>" . $row[3] . "</p>";
				echo "</div><hr>";
				// ---------------- TOP FIVE -----------------
				echo "<div>";
				echo "<h3>Top 3 Entries</h3>";
				// -------- GET TOTAL VOTE COUNT ----------
				$sql6 = "SELECT count(pkEntryID) AS fldCount FROM tblContestVote WHERE fkContestID='" . $row[5] . "'";
				$totalCount = mysql_query($sql6, $connectID);
				$rowTotalCount = mysql_fetch_array($totalCount);
				//echo "ROW TOTAL COUNT: " . $rowTotalCount[0];

				// --------- GET GROUP COUNT ---------------
				$sql2 = "SELECT count(fldVoteID) AS fldCount, pkEntryID FROM tblContestVote WHERE fkContestID='" . $row[5] . "' GROUP BY pkEntryID ORDER BY fldCount DESC LIMIT 0," . $rowTotalCount[0];
				
				$groupCount = 0;
				unset($entryArray);
				$tempCount = mysql_query($sql2, $connectID);
				while($rowCount = mysql_fetch_array($tempCount))
				{
					$groupCount++;
					//echo "GROUP COUNT: " . $rowCount[0] . " OF ENTRY: " . $rowCount[1];
					$entryArray[] = $rowCount[1];
				}
				

				// --------------- IF THERE HAS ALREADY BEEN VOTES SHOW THEM! ---------------
				if($groupCount != 0)
				{
					foreach($entryArray as $echo)
					{
						//GET THE VOTE COUNT FOR EACH ECHO
						$sql7 = "SELECT count(fldVoteID) AS fldCount FROM tblContestVote WHERE fkContestID='" . $row[5] . "' AND pkEntryID='" . $echo . "' GROUP BY pkEntryID ORDER BY fldCount DESC";
						$getGroupCount = mysql_query($sql7, $connectID);
						$arrayGroupCount = mysql_fetch_array($getGroupCount);


						//select those five by their ID's and display them
						$sql3 = "SELECT fldName, fldDescription, fldLink, pkEntryID, fldUsername FROM tblContestEntry WHERE pkEntryID='" . $echo . "' AND fkContestID='" . $row[5] . "'";
						$temp3 = mysql_query($sql3, $connectID);
						$row3 = mysql_fetch_array($temp3);
						echo "<div class='entryDiv'>";
							echo "<a style='text-decoration: none; color: #222222;' href='viewEntry.php?a=" . $row3[3]. "'><p style='font-size: 14px; font-weight: bold;'>" . $row3[0] . "</p></a>";
							echo "<hr>";
							echo "<iframe width='252' height='141' src='http://www.youtube.com/embed/" . $row3[2] . "' frameborder='0' allowfullscreen></iframe>";
							echo "<hr>";
							echo "Posted By: ";
							echo $row3[4];
							echo "</br>";
							echo "Total Votes: " . $arrayGroupCount[0];
							echo "</br>";
							echo "<p>";
							echo $row3[1];
							echo "</p>";
							//VOTE FOR ENTRY
							if($_SESSION['loggedIn'])
							{
								echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>";
								echo "<input type='hidden' name='entryPick' id='entryPick' value='" . $echo . "'/>";
								echo "<input type='hidden' name='contestPick' id='contestPick' value='" . $row[5] . "'/>";
								echo "<input type='hidden' name='startDate' id='startDate' value='" . $row[1] . "'/>";
								echo "<input type='hidden' name='stopDate' id='stopDate' value='" . $row[2] . "'/>";
								echo "<input type='submit' class='button' name='submitEntryVote' id='submitEntryVote' value='Vote'/>";
								echo "</form>";
							} 
						echo "</div>";
					}
					if($groupCount < 3)
					{
						// ------------------- IF THERE ISN'T 3 VIDEO LOAD THE REST! --------------------
						//select those five by their ID's and display them
						$newCount = 3 - $groupCount;
						$sql4 = "SELECT fldName, fldDescription, fldLink, pkEntryID, fldUsername FROM tblContestEntry WHERE fkContestID='" . $row[5] . "' ORDER BY fldDate DESC, fldTime DESC LIMIT 0," . $newCount;
						$temp4 = mysql_query($sql4, $connectID);
						while($row4 = mysql_fetch_array($temp4))
						{
							//get counts and ID's of votes
							$sql5 = "SELECT count(fldVoteID) AS fldCount FROM tblContestVote WHERE fkContestID='" . $row[5] . "' AND pkEntryID='" . $row4[3] . "' GROUP BY pkEntryID ORDER BY fldCount DESC LIMIT 0,3";
							$tempCount = mysql_query($sql5, $connectID);
							$rowCount = mysql_fetch_array($tempCount);
							if($rowCount[0] == "")
							{
								$rowCount[0] = 0;
							}

							echo "<div class='entryDiv'>";
								echo "<a style='text-decoration: none; color: #222222;' href='viewEntry.php?a=" . $row4[3] . "'><p style='font-size: 14px; font-weight: bold;'>" . $row4[0] . "</p></a>";
								echo "<hr>";
								echo "<iframe width='252' height='141' src='http://www.youtube.com/embed/" . $row4[2] . "' frameborder='0' allowfullscreen></iframe>";
								echo "<hr>";
								echo "Posted By: ";
								echo $row4[4];
								echo "</br>";
								echo "Total Votes: " . $rowCount[0];
								echo "</br>";
								echo "<p>";
								echo $row4[1];
								echo "</p>";
								//VOTE FOR ENTRY
								if($_SESSION['loggedIn'])
								{
									echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>";
									echo "<input type='hidden' name='entryPick' id='entryPick' value='" . $row4[3] . "'/>";
									echo "<input type='hidden' name='contestPick' id='contestPick' value='" . $row[5] . "'/>";
									echo "<input type='hidden' name='startDate' id='startDate' value='" . $row[1] . "'/>";
									echo "<input type='hidden' name='stopDate' id='stopDate' value='" . $row[2] . "'/>";
									echo "<input type='submit' class='button' name='submitEntryVote' id='submitEntryVote' value='Vote'/>";
									echo "</form>";
								} 
							echo "</div>";
						}
					}
				}
				else
				{
					// ------------------- IF THERE IS NO VOTES YET --------------------
					//select those five by their ID's and display them
					$sql4 = "SELECT fldName, fldDescription, fldLink, pkEntryID, fldUsername FROM tblContestEntry WHERE fkContestID='" . $row[5] . "' ORDER BY fldDate DESC, fldTime DESC LIMIT 0,3";
					$temp4 = mysql_query($sql4, $connectID);
					while($row4 = mysql_fetch_array($temp4))
					{
						//get counts and ID's of votes
						$sql5 = "SELECT count(fldVoteID) AS fldCount FROM tblContestVote WHERE fkContestID='" . $row[5] . "' AND pkEntryID='" . $row4[3] . "' GROUP BY pkEntryID ORDER BY fldCount DESC LIMIT 0,3";
						$tempCount = mysql_query($sql5, $connectID);
						$rowCount = mysql_fetch_array($tempCount);
						if($rowCount[0] == "")
						{
							$rowCount[0] = 0;
						}
					

		
						echo "<div class='entryDiv'>";
							echo "<a style='text-decoration: none; color: #222222;' href='viewEntry.php?a=" . $row4[3]. "'><p style='font-size: 14px; font-weight: bold;'>" . $row4[0] . "</p></a>";
							echo "<hr>";
							echo "<iframe width='252' height='141' src='http://www.youtube.com/embed/" . $row4[2] . "' frameborder='0' allowfullscreen></iframe>";
							echo "<hr>";
							echo "Posted By: ";
							echo $row4[4];
							echo "</br>";
							echo "Total Votes: " . $rowCount[0];
							echo "</br>";
							echo "<p>";
							echo $row4[1];
							echo "</p>";
							//VOTE FOR ENTRY
							if($_SESSION['loggedIn'])
							{
								echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>";
								echo "<input type='hidden' name='entryPick' id='entryPick' value='" . $row4[3] . "'/>";
								echo "<input type='hidden' name='contestPick' id='contestPick' value='" . $row[5] . "'/>";
								echo "<input type='hidden' name='startDate' id='startDate' value='" . $row[1] . "'/>";
								echo "<input type='hidden' name='stopDate' id='stopDate' value='" . $row[2] . "'/>";
								echo "<input type='submit' class='button' name='submitEntryVote' id='submitEntryVote' value='Vote'/>";
								echo "</form>";
							} 
						echo "</div>";
					}
				}









				echo "</div>";
				echo "<div style='clear:both'></div><hr>";

				// ------------ SHOW ALL VIDEOS -----------------				
				$sql8 = "SELECT fldName, fldDescription, fldLink, pkEntryID, fldUsername FROM tblContestEntry WHERE fkContestID='" . $row[5] . "' ORDER BY fldDate DESC, fldTime DESC";
				$temp8 = mysql_query($sql8, $connectID);
				echo "<div style='float: left; padding: 5px; width: 68%'>";
				echo "<h3>Check Out Everything Before You Vote!</h3>";
				echo "<div style='width: 100%; overflow:auto; height: 260px;'><table class='entryTable' cellspacing='0'>";
				$altCount = 0;
				while($row8 = mysql_fetch_array($temp8))
				{
					$altCount++;
					//get counts and ID's of votes
					$sql5 = "SELECT count(fldVoteID) AS fldCount FROM tblContestVote WHERE fkContestID='" . $row[5] . "' AND pkEntryID='" . $row8[3] . "' GROUP BY pkEntryID ORDER BY fldCount DESC LIMIT 0,3";
					$tempCount = mysql_query($sql5, $connectID);
					$rowCount = mysql_fetch_array($tempCount);
					if($rowCount[0] == "")
					{
						$rowCount[0] = 0;
					}


					if($altCount % 2 == 0)
					{
						//ODD ALTER
						echo "<tr>";
						echo "<td class='evenEntry'>";
							echo "<a style='text-decoration: none; color: #222222;' href='viewEntry.php?a=" . $row8[3]. "'><img src='http://img.youtube.com/vi/" . $row8[2] . "/1.jpg'/></a>";
							echo "</td>";
						echo "<td class='evenEntry'>";
							echo "<a style='text-decoration: none; color: #222222;' href='viewEntry.php?a=" . $row8[3]. "'><p style='font-style: bold; font-size: 15px;'>" . $row8[0] . " - " . $row8[4] . " - " . $rowCount[0] . "</p></a>";
							echo "<p style='font-size: 10px;'>" . $row8[1] . "</p>";
						echo "</td>";
						echo "</tr>";
					}
					else
					{
						//EVEN ALTER
						echo "<tr style='padding: 0px; margin: 0px;'>";
						echo "<td class='oddEntry'>";
							echo "<a style='text-decoration: none; color: #222222;' href='viewEntry.php?a=" . $row8[3]. "'><img src='http://img.youtube.com/vi/" . $row8[2] . "/1.jpg'/></a>";
							echo "</td>";
						echo "<td class='oddEntry'>";
							echo "<a style='text-decoration: none; color: #222222;' href='viewEntry.php?a=" . $row8[3]. "'><p style='font-style: bold; font-size: 15px;'>" . $row8[0] . " - " . $row8[4] . " - " . $rowCount[0] . "</p></a>";
							echo "<p style='font-size: 10px;'>" . $row8[1] . "</p>";
						echo "</td>";
						echo "</tr>";
					}
					
				}
				echo "</table></div>";
				echo "</div>";
				echo "<div style='float: left; border-left: 1px solid white; padding: 5px; width: 28%; height: 285px;'>";
				// -------------- NEW CONTEST ----------------
				echo "<h3>Submit A Contest Entry</h3>";
				if($_SESSION['loggedIn'])
				{
					echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>
					<label>Title / Crew</label>
					</br>
					<input type='hidden' name='contestPick' id='contestPick' value='" . $row[5] . "'/>
					<input type='hidden' name='startDate' id='startDate' value='" . $row[1] . "'/>
					<input type='hidden' name='stopDate' id='stopDate' value='" . $row[2] . "'/>

					<input type='text' size='30' name='title' id='title' value='" . $_POST['title'] . "'/>
					</br>
					<label>Description</label>
					</br>
					<textarea cols='25' rows='5' name='description' id='description'>";
					echo $_POST['description'];
					echo "</textarea>
					</br>
					<label>Youtube URL or YouTube Share Link, <span style='color: red;'>*NOT USE EMBED LINK*</span></lable>
					</br>
					<input type='text' size='30' name='link' id='link' value='" . $_POST['link'] . "'/>
					</br>
					<input type='submit' class='button' style='margin: 0px; margin-top: 5px; padding: 0px; padding-left: 5px; padding-right: 5px;'name='submitNewEntry' id='submitNewEntry' value='Submit Entry To Contest'/>
					</form>";
				}
				else
				{
					echo "<p>You Must Be Signed In Before You Can Enter The Contest!</p>";
				}
				echo "</div>";
				echo "<div style='clear: both;'></div>";
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