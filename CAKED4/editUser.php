<?php
include 'phpValidate.php';

// -------------------------------------------------------
// ----------------- FIRST AND LAST NAME -----------------
// -------------------------------------------------------
if(isset($_POST['changeName']))
{
	$_POST['fName'] = filter_var($_POST['fName'], FILTER_SANITIZE_STRING);
	$_POST['lName'] = filter_var($_POST['lName'], FILTER_SANITIZE_STRING);

	if($_POST['fName'] == "")
	{
		$errorMsg[] = "Your First Name Cannot Be Blank";
	}
	if($_POST['lName'] == "")
	{
		$errorMsg[] = "Your Last Name Cannot Be Blank";
	}
	if(!verifyAlphaNum($_POST['fName']))
	{
		$errorMsg[] = "First Name Contains Illigal Characters (letters, numbers)";
	}
	if(!verifyAlphaNum($_POST['lName']))
	{
		$errorMsg[] = "Last Name Contains Illigal Characters (letters, numbers)";
	}
	if(!$errorMsg)
	{
		if(!isset($_SESSION['fNamefName']))
		{
			$_SESSION['fName'] = "";
		}
		if(!isset($_SESSION['lName']))
		{
			$_SESSION['lName'] = "";
		}
		$sql = "UPDATE tblUsers SET fldFName='" . $_POST['fName'] . "', fldLName='" . $_POST['lName'] . "' WHERE fldUsername='" . $_SESSION['username'] . "'";
		
		$_SESSION['fName'] = $_POST['fName'];
		$_SESSION['lName'] = $_POST['lName'];
		if(mysql_query($sql, $connectID))
		{
			$succMsg[] = "Your Name Has Been Updated!";
		}
		else
		{
			$errorMsg[] = "An Error Has Occured, Please Try Again.";
		}
		
	}
}

// -------------------------------------------------------
// ----------------- CHANGE PASSSWORD --------------------
// -------------------------------------------------------
if(isset($_POST['changePassword']))
{
	$sql = "SELECT fldPassword FROM tblUsers WHERE fldUsername='" . $_SESSION['username'] ."'";
	$temp = mysql_query($sql, $connectID);
	$row = mysql_fetch_array($temp);

	if($row[0] == md5($_POST['oldPass']))
	{
		if($_POST['newPass1'] == $_POST['newPass2'])
		{
			//SANITIZE password
			if($_POST['newPass1'] == "")
			{
				$errorMsg[] = "Your Password Cannot Be Blank";
			}
			else
			{
				$passwordCheck = filter_var($_POST['newPass1'], FILTER_SANITIZE_STRING);
				if($passwordCheck == "")
				{
					$errorMsg[] = "Your Password Cannot Be Blank";
				}
				elseif(!verifyAlphaNum($passwordCheck))
				{
					$errorMsg[] = "Password Contains Illigal Characters (letters, numbers)";
				}
				elseif(strlen($passwordCheck) < 5)
				{
					$errorMsg[] = "Password Must Be Equal To Or Longer Than 5 Characters";
				}

				// IF NO ERROR MESSAGES DO THE DAMN THING!
				if(!$errorMsg)
				{
					$sql = "UPDATE tblUsers SET fldPassword='" . md5($passwordCheck) . "'";
					if($temp = mysql_query($sql, $connectID))
					{
						$succMsg[] = "Your Password Has Been Changed!";
					}
					else
					{
						$errorMsg[] = "An Error Has Occured And Your Password Was Not Changed. Please Try Again!";
					}
				}
			}
		}
		else
		{
			$errorMsg[] = "Your Two New Passwords Do Not Match!";
		}
	}
	else
	{
		$errorMsg[] = "Your Old Password Was Not Correct";
	}
}

// -------------------------------------------------------
// ----------------- CHANGE ADDRESS ----------------------
// -------------------------------------------------------
if(isset($_POST['changeAddress']))
{
	$_POST['address'] = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
	$_POST['city'] = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
	$_POST['state'] = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
	$_POST['zip'] = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);
	$_POST['country'] = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
	
	if($_POST['address'] == "")
	{
		$errorMsg[] = "Address Cannot Be Blank (EX: 21 Spear Street)";
	}
	if($_POST['city'] == "")
	{
		$errorMsg[] = "city Cannot Be Blank (EX: Tahoe City)";
	}
	if($_POST['state'] == "")
	{
		$errorMsg[] = "State Cannot Be Blank (EX: Vermont)";
	}
	if($_POST['zip'] == "")
	{
		$errorMsg[] = "Zip Cannot Be Blank (EX: 05482 or However Canada Does It...)";
	}

	if(!verifyAlphaNum($_POST['address']))
	{
		$errorMsg[] = "Address Contains Illigal Characters (letters, numbers)";
	}
	if(!verifyAlphaNum($_POST['city']))
	{
		$errorMsg[] = "City Contains Illigal Characters (letters, numbers)";
	}
	if(!verifyAlphaNum($_POST['state']))
	{
		$errorMsg[] = "State Contains Illigal Characters (letters, numbers)";
	}
	if(!verifyAlphaNum($_POST['zip']))
	{
		$errorMsg[] = "Zip Contains Illigal Characters (letters, numbers)";
	}
	if(!verifyAlphaNum($_POST['country']))
	{
		$errorMsg[] = "Country Contains Illigal Characters (letters, numbers)";
	}

	if(!$errorMsg)
	{
		$sql = "UPDATE tblUsers SET fldAddress='" . $_POST['address'] . "', fldCity='" . $_POST['city'] . "', fldState='" . $_POST['state'] . "', fldZip='" . $_POST['zip'] . "', fldCountry='" . $_POST['country'] . "' WHERE fldUsername='" . $_SESSION['username'] . "'";
		$_SESSION['address'] = $_POST['address'];
		$_SESSION['city'] = $_POST['city'];
		$_SESSION['state'] = $_POST['state'];
		$_SESSION['zip'] = $_POST['zip'];
		$_SESSION['country'] = $_POST['country'];
		if(mysql_query($sql, $connectID))
		{
			$succMsg[] = "Your Shipping Information Has Been Updated!";
		}
		else
		{
			$errorMsg[] = "An Error Has Occured, Please Try Again";
		}
	}
}

// -------------------------------------------------------
// ----------------- CONTEST ENTIRES ---------------------
// -------------------------------------------------------
if(isset($_POST['changeEntries']))
{

}

// -------------------------------------------------------
// ----------------- CONTEST VOTES -----------------------
// -------------------------------------------------------
if(isset($_POST['changeVotes']))
{

}

// -------------------------------------------------------
// ----------------- CONTEST WINNINGS --------------------
// -------------------------------------------------------
if(isset($_POST['changeWinnings']))
{

}
?>