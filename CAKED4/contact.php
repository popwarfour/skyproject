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

	if(isset($_POST["submitEmail"]))
	{
		include("contact1.php");
	}
	if(isset($_POST["submitText"]))
	{
		include("contact2.php");
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Anders D Melen" />
	<meta name="description" content="Caked Snowboards - Get Gear, Join The Contest, GetWitIt" />
	<META NAME="Title" CONTENT="Caked Snowboards - Contact">
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
		<?php
			if($errorMsg)
	        {
	        	/*------- login STUFF --------------*/
				include("jquery.php");

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
				include("jquery.php");
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
			<h1>Contact</h1>
						<!-- MAIL FORM -->
	<table style='margin-left: 80px;'>
  	<tr>
    	<td width="325px">
        <div id="join-email-container">
      		<center>
      		<img src="images/email.png" alt="email image">
      	
        	<h3>Email Us</h3>
      		</center>
         	<?php echo "<form action='" . $_POST['PHP_SELF'] . "' method='post' id='join-content-form'>"; ?>
        	<fieldset class="intro">
          			<legend>Ask Us A Question!</legend>
          			<fieldset>
      						<center>
          				<label for="name"><b>Name</b></label>
      						</br>
        				<?php echo "<input type='text' id='name' name='name' size='34' maxlength='20' value='" . $_POST['name'] . "'/>"; ?>
          				</br>
          				<label for="useremail"><b>Your Email</b></label>
      						</br>
            			<?php echo "<input type='text' id='useremail' name='useremail' size='34' maxlength='30' value='" . $_POST['useremail'] . "'/>"; ?>
          				</br>
      						<label for="question"><b>Your Question:</b></label>
      						</br>
          				<?php echo "<textarea id='question' name='question' cols='25' rows='4'>" . $_POST['question'] . "</textarea>"; ?>
      						</center>
          			</fieldset>
          			<fieldset>
      					<center>
                  <input type="submit" id="submitEmail" name="submitEmail" value="Send"/>
      					</center>
          			</fieldset>
          		</fieldset>
          	</form>	
        </div>
      </td>
    	
    	<!-- FORM 2 -->
    	<td width="325px">
    	<div id="join-text-container">
    	<center>
    		<img src="images/sms.png" alt="email image">
      	<h3>Text Message Us</h3>
    		</center>
      	<?php echo "<form action='" . $_POST['PHP_SELF'] . "' method='post' id='join-content-form'>"; ?>
        		<fieldset class="intro">
    					<legend>Ask Us A Question!</legend>
        				<fieldset>
    						<center>
        					<label for="Pname"><b>Name:</b></label>
    							</br>
      						<?php echo "<input type='text' id='pName' name='pName' size='34' maxlength='20' value='" . $_POST['pName'] . "'/>"; ?>
        						</br>
        					<label for="userphone"><b>Phone Number:</b> (XXX)XXX-XXXX</label>
    							</br>
          					<?php echo "<input type='text' id='userphone' name='userphone' size='34' maxlength='30' value='" . $_POST['userphone'] . "'/>"; ?>
        						</br>
    								<label for="question"><b>Your Question:</b></label>
    								</br>
        						<?php echo "<textarea id='pQuestion' name='pQuestion' cols='25' rows='4'>" . $_POST['pQuestion'] . "</textarea>"; ?>
    								</center>
        				</fieldset>
        				<fieldset>
    						<center>
                	<input type="submit" name='submitText' id='submitText' value="Send"/>
    						</center>
        				</fieldset>
        			</fieldset>
        		</form>
      	</div>
    	</td>
  	</tr>
	</table>
		</div>
	</div>

	<!-- ------------- FOOTER DIV --------- -->
	<div id='footerDiv'>
		<center>
		Site Created By: ADM Designs &copy; 2012 | For More Information Visit My Page at <a href='http://www.uvm.edu/~amelen/cs142/assign5/index.php'>ADM Web Designs</a>
		</center>	
	</div>


	
</body>
</html>