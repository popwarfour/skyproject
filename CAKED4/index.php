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

	// -------------------- SUBMIT COMMENT -----------------------------
	if(isset($_POST['submitComment']))
	{
		if($_POST['comment'] == "")
		{
			$errorMsg[] = "Your Comment Cannot Be Blank";
		}
		else
		{
			$_POST['comment'] = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
			if($_POST['comment'] == "")
			{
				$errorMsg[] = "Your Comment Cannot Be Blank";
			}
		}

		if(!$errorMsg)
		{
			$sql = "INSERT INTO tblPostComments SET ";
			$sql .= "fldUsername='" . $_SESSION['username'] . "', ";
			$sql .= "fkPostID='" . $_POST['postPick'] . "', ";
			$sql .= "fldDate='" . date("o-m-d") . "', "; 
			$sql .= "fldTime='" . date("H:i:s") . "', "; 
			$sql .= "fldComment='" . $_POST['comment'] . "'"; 
			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "Your Comment Has Been Posted";
			}
			else
			{
				$errorMsg[] = "Some Went Wrong When Trying To Post Your Comment, Please Try Again";
			}
		}
	}
	// --------------------- REMOVE COMMENT ------------------------
	if(isset($_POST['submitRemoveComment']))
	{
		$sql = "DELETE FROM tblPostComments WHERE pkCommentID='" . $_POST['commentPick'] . "'";
		if(mysql_query($sql, $connectID))
		{
			$succMsg[] = "Your Comment Has Been Removed";
		}
		else
		{
			$errorMsg[] = "Some Went Wrong When Trying To Post Your Comment, Please Try Again";
		}
	}

	//default comment limit
	if(!$_SESSION['limit'])
	{
		$_SESSION['limit'] = 5;
	}
	// ------------------ CHANGE COMMENT LIMIT ------------------
	if(isset($_POST['changeCommentCount']))
	{
		$_SESSION['limit'] = $_POST['count'];
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Anders D Melen" />
	<meta name="description" content="Caked Snowboards - Get Gear, Join The Contest, GetWitIt" />
	<META NAME="Title" CONTENT="Caked Snowboards - Home">
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

			$sql = "SELECT fldUsername, fldTime, fldDate, fldDescription, fldTitle, pkPostID FROM tblPosts ORDER BY pkPostID DESC LIMIT 10";
			$temp = mysql_query($sql,$connectID);
			while($row = mysql_fetch_array($temp))
			{
				echo "<div class='postDiv'>";
					echo "<div class='postDivContent' style='padding-bottom: 0px;'>";
						//title
						echo "<center><h2>" . $row[4] . "</h2></center>";
						echo "</br>";
						
						//images
						$sql2 = "SELECT fldImage FROM tblPostImages WHERE fkPostID='" . $row[5] . "' ORDER BY pkImageID";
						$temp2 = mysql_query($sql2, $connectID);
						$temp999 = mysql_query($sql2, $connectID);
						$counter2 = 0;
						while($row999 = mysql_fetch_array($temp999))
						{
							$counter2++;
						}
						
						if($counter2 == 1)
						{
							$row2 = mysql_fetch_array($temp2);
							echo "<div style='float: left; border: 1px solid black; margin: 10px; margin-left: 240px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
							
							echo "<a href='../uploads/" . $row2[0] . "'><img src='../uploads/" . $row2[0] . "' alt='postImage' height='200px' width='300px'/></a></div>";
							echo "<div style='clear: both;'></div>";
						}
						else
						{

							$counter = 0;
							while($row2 = mysql_fetch_array($temp2))
							{
								if($counter % 2 == 0)
								{
									echo "<div style='float: left; border: 1px solid black; margin: 10px; margin-left: 50px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
								}
								else
								{
									echo "<div style='float: right; border: 1px solid black; margin: 10px; margin-right: 50px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
								}
								echo "<a href='../uploads/" . $row2[0] . "'><img src='../uploads/" . $row2[0] . "' alt='postImage' height='200px' width='300px'/></a></div>";
								$counter++;
							}
							echo "<div style='clear: both;'></div>";
						}
						
						//description DIV
						echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
							
							//poster information
							$date = DATE("M j Y", STRTOTIME($row[2]));
							$time  = DATE("g:i a", STRTOTIME($row[1]));
							echo "<span style='font-weight: bold;'>Posted By: " . $row[0] . " | " . $date . ", " . $time . "</span>";
							echo "</br><hr>";
							//description
							echo $row[3];
						echo "</div>";
					echo "</div>";			

					$sql99 = "SELECT fldUsername FROM tblPostComments WHERE fkPostID='" . $row[5] . "'";
					$temp4 = mysql_query($sql99, $connectID);
					$row99 = mysql_fetch_array($temp4);
					if(count($row99[0]) > 0 || $_SESSION['loggedIn'])
					{
						echo "<hr>";
					}


					if($_SESSION['loggedIn'])
					{
						//COMMENT FORM
						echo "<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
							echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' class='noMargin'>
									<textarea name='comment' id='comment' rows='3' cols='92'></textarea>
									</br>
									<input type='hidden' name='postPick' id='postPick' value='" . $row[5] . "'/>
									<input type='submit' class='button' name='submitComment' id='submitComment' value='Post Comment'/>
								</form>";
						echo "</div>";
					}


					//SHOW THE COMMENTS

					if($_SESSION['limit'] > 50)
					{
						$sql = "SELECT fldUsername, fldDate, fldTime, fldComment, pkCommentID FROM tblPostComments WHERE fkPostID='" . $row[5] . "' ORDER BY fldDate DESC, fldTime DESC";
					}
					else
					{
						$sql = "SELECT fldUsername, fldDate, fldTime, fldComment, pkCommentID FROM tblPostComments WHERE fkPostID='" . $row[5] . "' ORDER BY fldDate DESC, fldTime DESC LIMIT 0," . $_SESSION['limit'] . "";
					}

					$temp3 = mysql_query($sql, $connectID);

					$counter = 0;
					while($row3 = mysql_fetch_array($temp3))
					{					
						$count++;
						if($count % 2 == 0)
						{
							echo "<div class='commentDiv'>";
						}
						else
						{
							echo "<div class='commentAltDiv'>";
						}

							echo $row3[3];
							echo "<hr>";

							$date2 = DATE("M j Y", STRTOTIME($row3[1]));
							$time2  = DATE("g:i a", STRTOTIME($row3[2]));
							echo "Posted By: " . $row3[0] . " | " . $date . ", " . $time;
							if($_SESSION['adminLevel'] > 1 || $_SESSION['username'] == $row3[0])
							{
								echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' class='noMargin'>
								<input type='hidden' name='commentPick' id='commentPick' value='" . $row3[4] . "'/>
								<input type='submit' class='button' name='submitRemoveComment' id='submitRemoveComment' value='Remove Comment'/>
								</form>";
							}
						echo "</div>";
					}
				echo "</div>";
			}
		?>
	</div>

	<?php
		echo "<div class='commentChoiceDiv'>";
			echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' class='noMargin'>
					<label>Hide</label>";

					if($_SESSION['limit'] == 0)
					{
						echo "<input type='radio' class='commentChoice' checked name='count' id='count' value='0'/>";
					}
					else
					{
						echo "<input type='radio' class='commentChoice' name='count' id='count' value='0'/>";
					}

					echo "|\t<label>5</label>";
					if($_SESSION['limit'] == 5)
					{
						echo "<input type='radio' class='commentChoice' checked name='count' id='count' value='5'/>";
					}
					else
					{
						echo "<input type='radio' class='commentChoice' name='count' id='count' value='5'/>";
					}

					echo "|\t<label>10</label>";
					if($_SESSION['limit'] == 10)
					{
						echo "<input type='radio' class='commentChoice' checked name='count' id='count' value='10'/>";
					}
					else
					{
						echo "<input type='radio' class='commentChoice' name='count' id='count' value='10'/>";
					}

					echo "|\t<label>25</label>";
					if($_SESSION['limit'] == 25)
					{
						echo "<input type='radio' class='commentChoice' checked name='count' id='count' value='25'/>";
					}
					else
					{
						echo "<input type='radio' class='commentChoice' name='count' id='count' value='25'/>";
					}

					echo "|\t<label>50</label>";
					if($_SESSION['limit'] == 50)
					{
						echo "<input type='radio' class='commentChoice' checked name='count' id='count' value='50'/>";
					}
					else
					{
						echo "<input type='radio' class='commentChoice' name='count' id='count' value='50'/>";
					}

					echo "|\t<label>All</label>";
					if($_SESSION['limit'] > 51)
					{
						echo "<input type='radio' class='commentChoice' checked name='count' id='count' value='9999999999'/>";
					}
					else
					{
						echo "<input type='radio' class='commentChoice' name='count' id='count' value='9999999999'/>";
					}

					echo "\t<input type='submit' class='button' style='margin: 0px; margin-left: 5px;padding: 0px; padding-left: 5px; padding-right: 5px;' name='changeCommentCount' id='changeCommentCount' value='Change'/>
				</form>";
			echo "</div>";
		?>
	<!-- ------------- FOOTER DIV --------- -->
	<div id='footerDiv'>
		<center>
		Site Created By: ADM Designs &copy; 2012 | For More Information Visit My Page at <a href='http://www.uvm.edu/~amelen/cs142/assign5/index.php'>ADM Web Designs</a>
		</center>	
	</div>


	
</body>
</html>