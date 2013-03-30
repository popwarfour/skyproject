<?php
	if(isset($_POST['submitLogin']))
	{
		//SANITIZE
		//USERNAME
		if($_POST['username'] == "")
		{
			$errorMsg[] = "Your Username Cannot Be Blank";
		}
		else
		{
			$_POST['username'] = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
			if($_POST['username'] == "")
			{
				$errorMsg[] = "Your Username Cannot Be Blank";
			}
		}
		//PASSWORD
		if($_POST['password'] == "")
		{
			$errorMsg[] = "Your Password Cannot Be Blank";
		}
		else
		{
			$_POST['password'] = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
			if($_POST['password'] == "")
			{
				$errorMsg[] = "Your Password Cannot Be Blank";
			}
		}

		// LOGIN STUFF ------------------------------------------------
		//GET SQL USER INFO
		if(!$errorMsg)
		{
			$sql = "SELECT fldUsername, fldFName, fldLName, fldEmail, fldAdminLevel, fldAddress, fldCity, fldState, fldZip, fldCountry FROM tblUsers WHERE fldUsername='" . $_POST['username'] . "' AND fldPassword='" . md5($_POST['password']) . "' AND fldAdminLevel>'0'";

/*			echo count($errorMsg);
			echo "</br>" . $_POST['username'];
			echo "</br>" . $_POST['password'];
*/
			$temp = mysql_query($sql, $connectID);
			$row = mysql_fetch_array($temp);

			if(count($row) > 1)
			{
				$_SESSION['username'] = $row[0];
				$_SESSION['fName'] = $row[1];
				$_SESSION['lName'] = $row[2];
				$_SESSION['email'] = $row[3];
				$_SESSION['adminLevel'] = $row[4];
				$_SESSION['loggedIn'] = true;
				$_SESSION['limit'] = 5;
				$_SESSION['address'] = $row[5];
				$_SESSION['city'] = $row[6];
				$_SESSION['state'] = $row[7];
				$_SESSION['zip'] = $row[8];
				$_SESSION['country'] = $row[9];
			}
			else
			{
				$errorMsg[] = "Login Combination Not Found";
			}
		}
	}
	else
	{	
		if(!isset($_SESSION['username']))
		{
			$_SESSION['username'] = "";
		}
		if(!isset($_SESSION['fName']))
		{
			$_SESSION['fName'] = "";
		}
		if(!isset($_SESSION['lName']))
		{
			$_SESSION['lName'] = "";
		}
		if(!isset($_SESSION['email']))
		{
			$_SESSION['email'] = "";
		}
		if(!isset($_SESSION['adminLevel']))
		{
			$_SESSION['adminLevel'] = 0;
		}
		if(!isset($_SESSION['loggedIn']))
		{
			$_SESSION['loggedIn'] = false;
		}
		if(!isset($_SESSION['address']))
		{
			$_SESSION['address'] = "";
		}
		if(!isset($_SESSION['city']))
		{
			$_SESSION['city'] = "";
		}
		if(!isset($_SESSION['state']))
		{
			$_SESSION['state'] = "";
		}
		if(!isset($_SESSION['zip']))
		{
			$_SESSION['zip'] = "";
		}
		if(!isset($_SESSION['limit']))
		{
			$_SESSION['limit'] = 5;
		}
	}
	// LOGIN STUFF ---------------------------------------------
	if(isset($_POST['submitResetPassword']))
	{
		$errorMsg[] = "Please Follow the Instructions To Reset Your Password";
	}
?>