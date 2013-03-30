<?php
	include 'phpValidate.php';

	//CHECK FOR DUPLICATES FIRST
	$dupCheck = "SELECT fldusername FROM tblUsers";
	$checkusernames = mysql_query($dupCheck, $connectID);
	$found = false;

	if(!isset($_POST['username']))
	{
		$_POST['username'] == "";
	}
	if(!isset($_POST['password']))
	{
		$_POST['password'] == "";
	}
	if(!isset($_POST['fName']))
	{
		$_POST['fName'] == "";
	}
	if(!isset($_POST['lName']))
	{
		$_POST['lName'] == "";
	}
	if(!isset($_POST['email']))
	{
		$_POST['email'] == "";
	}

	while($usernames = mysql_fetch_array($checkusernames))
	{
		if($usernames[0] == $_POST["username"])
		{
			$errorMsg[] = "That username Already Excists, Try a Different One";
		}
	}
	
	//SANITIZE username
	if($_POST['username'] == "")
	{
		$errorMsg[] = "Your username Cannot Be Blank";
	}
	else
	{
		$_POST['username'] = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		if($_POST['username'] == "")
		{
			$errorMsg[] = "Your username Cannot Be Blank";
		}
		elseif(!verifyAlphaNum($_POST['username']))
		{
			$errorMsg[] = "username Contains Illigal Characters (letters, numbers)";
		}
		elseif(strlen($_POST['username']) < 5)
		{
			$errorMsg[] = "username Must Be Equal To Or Longer Than 5 Characters";
		}
	}
	//SANITIZE password
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
		elseif(!verifyAlphaNum($_POST['password']))
		{
			$errorMsg[] = "Password Contains Illigal Characters (letters, numbers)";
		}
		elseif(strlen($_POST['password']) < 5)
		{
			$errorMsg[] = "Password Must Be Equal To Or Longer Than 5 Characters";
		}
	}

	//SANITIZE email
	if($_POST['email'] == "")
	{
		$errorMsg[] = "Your Email Cannot Be Blank";
	}
	else
	{
		$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		if($_POST['email'] == "")
		{
			$errorMsg[] = "Your Email Cannot Be Blank";
		}
		elseif(!verifyEmail($_POST['email']))
		{
			$errorMsg[] = "Email Contains Illigal Characters (letters, numbers | FORMAT: xxx@xxx.xxx)";
		}
	}


	//SANITIZE first name
	if($_POST['fName'] == "")
	{
		$errorMsg[] = "Your First Name Cannot Be Blank";
	}
	else
	{
		$_POST['fName'] = filter_var($_POST['fName'], FILTER_SANITIZE_STRING);
		if($_POST['fName'] == "")
		{
			$errorMsg[] = "Your First Name Cannot Be Blank";
		}
		elseif(!verifyAlphaNum($_POST['fName']))
		{
			$errorMsg[] = "First Name Contains Illigal Characters (letters, numbers, ?, !)";
		}
		elseif(strlen($_POST['fName']) < 2)
		{
			$errorMsg[] = "First Name Must Be Equal To Or Longer Than 2 Characters";
		}
	}

	//SANITIZE last name
	if($_POST['lName'] == "")
	{
		$errorMsg[] = "Your Last Name Cannot Be Blank";
	}
	else
	{
		$_POST['lName'] = filter_var($_POST['lName'], FILTER_SANITIZE_STRING);
		if($_POST['lName'] == "")
		{
			$errorMsg[] = "Your Last Name Cannot Be Blank";
		}
		elseif(!verifyAlphaNum($_POST['lName']))
		{
			$errorMsg[] = "Last Name Contains Illigal Characters (letters, numbers, ?, !)";
		}
		elseif(strlen($_POST['lName']) < 2)
		{
			$errorMsg[] = "username Must Be Equal To Or Longer Than 2 Characters";
		}
	}
?>