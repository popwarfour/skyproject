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



	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- C_O_N_T_E_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------



	// ------------ REMOVE CONTEST --------------
	if(isset($_POST['submitRemoveContest']))
	{
		if(!isset($_POST['contestPick']))
		{
			$errorMsg[] = "You Must Select A Contest To Remove";
		}

		if(!$errorMsg)
		{
			$sql = "DELETE FROM tblContest WHERE pkContestID='" . $_POST['contestPick'] . "'";
			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "The Contest Has Been Removed!";
			}
			else
			{
				$errorMsg[] = "Something Went Wrong When Trying To Remove Your Contest, Try Again";
			}
		}

		//REMOVE CONTEST ENTRIES
		$sql = "DELETE FROM tblContestEntry WHERE fkContestID='" . $_POST['contestPick'] . "'";
		if(mysql_query($sql, $connectID))
		{
			$succMsg[] = "The Contest Entries Have Been Removed!";
		}
		else
		{
			$errorMsg[] = "Something Went Wrong When Trying To Remove The Contests Entries, Contact Anders!";
		}

		//REMOVE CONTEST VOTES
		$sql = "DELETE FROM tblContestVote WHERE fkContestID='" . $_POST['contestPick'] . "'";
		if(mysql_query($sql, $connectID))
		{
			$succMsg[] = "The Contest Votes Have Been Removed!";
		}
		else
		{
			$errorMsg[] = "Something Went Wrong When Trying To Remove The Contests Votes, Contact Anders!";
		}
	}
	// ------------- SUBMIT NEW CONTEST POST --------------
	if(isset($_POST['submitNewContest']))
	{
		//SANITIZE START DATE
		if($_POST['contestStartDate'] == "" || $_POST['contestStartDate'] == null)
		{
			$errorMsg[] = "You Must Choose a Start Date";
		}

		//SANITIZE End Date
		if($_POST['contestEndDate'] == "" || $_POST['contestEndDate'] == null)
		{
			$errorMsg[] = "You Must Choose a End Date";
		}

		$_POST['contestTitle'] = filter_var($_POST['contestTitle'], FILTER_SANITIZE_STRING);
		//SANITIZE TITLE
		if($_POST['contestTitle'] == "")
		{
			$errorMsg[] = "Contest Title Cannot Be Blank";
		}

		$_POST['contestDescription'] = filter_var($_POST['contestDescription'], FILTER_SANITIZE_STRING);
		//SANITIZE DESCRIPTION
		if($_POST['contestDescription'] == "")
		{
			$errorMsg[] = "Contest Description Cannot Be Blank";
		}


		if(!$errorMsg)
		{
			$contestStartDate = DATE("Y-m-d", STRTOTIME($_POST['contestStartDate']));
			$contestEndDate = DATE("Y-m-d", STRTOTIME($_POST['contestEndDate']));


			$sql = "INSERT INTO tblContest SET fldTitle='" . $_POST['contestTitle'] . "', fldDescription='" . $_POST['contestDescription'] . "', fldStartDate='" . $contestStartDate . "', fldEndDate='" . $contestEndDate . "', fkUsername='" . $_SESSION['username'] . "'";

			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "The New Contest Has Been Created";
			}
			else
			{
				$errorMsg[] = "Something Happened And Your Contest Was Not Created, Please Try Again";
			}
		}
		if(!$errorMsg & $succMsg)
		{
			$_POST['contestTitle'] = "";
			$_POST['contestDescription'] = "";
			$_POST['contestStartDate'] = "";
			$_POST['contestEndDate'] = "";
		}
	}


	// ------------- RE-SUBMIT NEW CONTEST POST --------------
	if(isset($_POST['resubmitNewContest']))
	{
		//SANITIZE START DATE
		if($_POST['contestStartDate'] == "" || $_POST['contestStartDate'] == null)
		{
			$errorMsg[] = "You Must Choose a Start Date";
		}

		//SANITIZE End Date
		if($_POST['contestEndDate'] == "" || $_POST['contestEndDate'] == null)
		{
			$errorMsg[] = "You Must Choose a End Date";
		}

		$_POST['contestTitle'] = filter_var($_POST['contestTitle'], FILTER_SANITIZE_STRING);
		//SANITIZE TITLE
		if($_POST['contestTitle'] == "")
		{
			$errorMsg[] = "Contest Title Cannot Be Blank";
		}

		$_POST['contestDescription'] = filter_var($_POST['contestDescription'], FILTER_SANITIZE_STRING);
		//SANITIZE DESCRIPTION
		if($_POST['contestDescription'] == "")
		{
			$errorMsg[] = "Contest Description Cannot Be Blank";
		}


		if(!$errorMsg)
		{
			$contestStartDate = DATE("Y-m-d", STRTOTIME($_POST['contestStartDate']));
			$contestEndDate = DATE("Y-m-d", STRTOTIME($_POST['contestEndDate']));

			$sql = "UPDATE tblContest SET fldTitle='" . $_POST['contestTitle'] . "', fldDescription='" . $_POST['contestDescription'] . "', fldStartDate='" . $contestStartDate . "', fldEndDate='" . $contestEndDate . "', fkUsername='" . $_SESSION['username'] . "' WHERE pkContestID='" . $_POST['contestPick'] . "'";

			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "The Contest Has Been Updated";
			}
			else
			{
				$errorMsg[] = "Something Happened And Your Contest Was Not Updated, Please Try Again";
			}
		}
		if(!$errorMsg & $succMsg)
		{
			$_POST['contestTitle'] = "";
			$_POST['contestDescription'] = "";
			$_POST['contestStartDate'] = "";
			$_POST['contestEndDate'] = "";
		}
	}



	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- P_O_S_T ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------

	// ------------- RE-SUBMIT POST --------------
	if(isset($_POST['resubmitPost']))
	{
		//SANITIZE title
		$_POST['title'] = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
		if(!verifyAlphaNum($_POST['title']) & strlen($_POST['title']) != 0)
		{
			$errorMsg[] = "The Title Contains Illigal Characters (letters, numbers, ?, !)";
		}

		if(!$errorMsg)
		{
			$sql = "UPDATE tblPosts SET fldTitle='" . $_POST['title'] . "', fldDescription='" . $_POST['description'] . "' WHERE pkPostID='" . $_POST['postPick'] . "'";
			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "Your Post Has Been Changed";
			}
			else
			{
				$errorMsg[] = "Something Happened And Your Post Was Not Changed, Please Try Again";
			}
		}
		if(!$errorMsg & $succMsg)
		{
			$_POST['title'] = "";
			$_POST['description'] = "";
		}
	}
	// ------------- SUBMIT POST --------------
	if(isset($_POST['submitPost']))
	{
		//SANITIZE title
		$_POST['title'] = filter_var($_POST['title'], FILTER_SANITIZE_STRING);

		//hopefully my managers wont be sql injecting me?!?!
		/*
		if(!verifyAlphaNum($_POST['title']) & strlen($_POST['title']) != 0)
		{
			$errorMsg[] = "The Title Contains Illigal Characters (letters, numbers, ?, !)";
		}*/

		//SANITIZE description
		if($_POST['description'] == "")
		{
			$errorMsg[] = "Description Cannot Be Blank";
		}
		else
		{
			$_POST['description'] = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			if($_POST['description'] == "")
			{
				$errorMsg[] = "Description Cannot Be Blank";
			}

			//hopefully my managers wont be sql injecting me?!?!
			/*
			elseif(!verifyText($_POST['description']))
			{
				$errorMsg[] = "Description Contains Illigal Characters (letters, numbers, ?, !)";
			}*/

			elseif(strlen($_POST['description']) < 2)
			{
				$errorMsg[] = "Description Must Be Equal To Or Longer Than 2 Characters";
			}
		}

		if(!$errorMsg)
		{

			//UPDATE DATABASE
			$sql = "INSERT INTO tblPosts SET ";
			$sql .= "fldUsername='" . $_SESSION['username'] . "', ";
			$sql .= "fldDate='" . date("o-m-d") . "', "; 
			$sql .= "fldTime='" . date("H:i:s") . "', "; 
			$sql .= "fldTitle='" . $_POST['title'] . "', "; 
			$sql .= "fldDescription='" . $_POST['description'] . "'"; 
		    if(mysql_query($sql, $connectID))
		    {
		    	$succMsg[] = "Your Post Has Been Posted!";
		    }
		    else
		    {
		    	$errorMsg[] = "Something Went Wrong When Trying To Submit Your Post... Try Again";
		    }

		     //GET POST ID FOR IMAGES
		    $sql = "SELECT pkPostID FROM tblPosts ORDER BY pkPostID DESC";
		    $temp = mysql_query($sql, $connectID);
		    $row = mysql_fetch_array($temp);
		    $pkPostID = $row[0];

		    //IMAGE WORK
		    $imageCount = 0;

			if(basename($_FILES['image1']['name']) != null)
			{
				$imageCount++;
			}
			if(basename($_FILES['image2']['name']) != null)
			{
				$imageCount++;
			}


			$imageArray = array();
			for($i = 1; $i < ($imageCount + 1); $i++)
			{
				$text = "image" . $i;
				$target = "../uploads/";
				$sql = "SELECT fldImage FROM tblPostImages";
				$temp = mysql_query($sql, $connectID);
				$repeat = false;
				while($row = mysql_fetch_array($temp))
				{
					if($row[0] == basename($_FILES[$text]['name']))
					{
						$repeat = true;
					}
				}

				if($repeat)
				{
					$myRand = rand(0,100);
					$splitMe = explode(".",basename($_FILES[$text]['name']));
					$target .= $splitMe[0] . $myRand . "." . $splitMe[1];
					$imageName = $splitMe[0] . $myRand . "." . $splitMe[1];

				}
				else
				{
					$target .= basename($_FILES[$text]['name']);	
					$imageName = basename($_FILES[$text]['name']);
				}

				$imageArray[] = $imageName;
				move_uploaded_file($_FILES[$text]['tmp_name'], $target);
			}

			//INSERT IMAGE LINKS
			for($i = 0; $i < count($imageArray); $i++)
			{
				$sql = "INSERT INTO ";
			    $sql .= "tblPostImages SET ";
				$sql .= "fkPostID='" . $pkPostID . "', ";
				$sql .= "fldImage='" . $imageArray[$i] . "'";
				$myData = mysql_query($sql,$connectID); 
			}
		}

		if(!$errorMsg & $succMsg)
		{
			$_POST['title'] = "";
			$_POST['description'] = "";
		}
	}
	// ------------ REMOVE POST --------------
	if(isset($_POST['submitRemovePost']))
	{
		if(!isset($_POST['postPick']))
		{
			$errorMsg[] = "You Must Select A Post To Remove";
		}

		if(!$errorMsg)
		{
					$sql = "DELETE FROM tblPosts WHERE pkPostID='" . $_POST['postPick'] . "'";
		if(mysql_query($sql, $connectID))
		{
			$succMsg[] = "The Post Has Been Removed!";
		}
		else
		{
			$errorMsg[] = "Something Went Wrong When Trying To Remove Your Post, Try Again";
		}


		//REMOVE IMAGES
		//DELETE IMAGES FROM DIRECTORY
		$sql = "SELECT fldImage FROM tblPostImages WHERE fkPostID='" . $_POST['postPick'] . "'";
		$myData = mysql_query($sql,$connectID);
		while($imageArray = mysql_fetch_array($myData))
		{
			$myFile = "../uploads/" . $imageArray[0];
			unlink($myFile);
		}

		//DELETE IMAGES FROM DATABASE
		$sql = "DELETE FROM tblPostImages WHERE fkPostID='" . $_POST['postPick'] . "'";
		if(mysql_query($sql, $connectID))
		{
			$succMsg[] = "The Posts Images Have Been Removed!";
		}
		else
		{
			$errorMsg[] = "Something Went Wrong When Trying To Remove The Post's Images, Contact Anders!";
		}

		//REMOVE COMMENTS
		$sql = "DELETE FROM tblPostComments WHERE fkPostID='" . $_POST['postPick'] . "'";
		if(mysql_query($sql, $connectID))
		{
			$succMsg[] = "The Posts Comments Have Been Removed!";
		}
		else
		{
			$errorMsg[] = "Something Went Wrong When Trying To Remove The Post's Comments, Contact Anders!";
		}

		}
	}





	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- S_H_O_P ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------


	// ------------- RE-SUBMIT ITEM --------------
	if(isset($_POST['resubmitNewItem']))
	{
		//SANITIZE title
		$_POST['itemTitle'] = filter_var($_POST['itemTitle'], FILTER_SANITIZE_STRING);
		if(strlen($_POST['itemTitle']) == 0)
		{
			$errorMsg[] = "You Must Enter A Title!";
		}

		//SANITIZE description
		$_POST['itemDescription'] = filter_var($_POST['itemDescription'], FILTER_SANITIZE_STRING);
		if(strlen($_POST['itemDescription']) == 0)
		{
			$errorMsg[] = "You Must Enter A Description!";
		}

		if(!$errorMsg)
		{
			$sql = "UPDATE tblShop SET fldName='" . $_POST['itemTitle'] . "', fldQuantity='" . $_POST['itemQuantity'] . "', fldPrice='" . $_POST['itemPrice'] . "', fldDescription='" . $_POST['itemDescription'] . "', fldBuyNow='" . $_POST['itemBuy'] . "' WHERE pkItemID='" . $_POST['itemPick'] . "'";

			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "Your Item Has Been Changed";
			}
			else
			{
				$errorMsg[] = "Something Happened And Your Item Was Not Changed, Please Try Again";
			}
		}
		if(!$errorMsg & $succMsg)
		{
			$_POST['itemTitle'] = "";
			$_POST['itemQuantity'] = "";
			$_POST['itemPrice'] = "";
			$_POST['itemDescription'] = "";
		}
	}
	// ------------- SUBMIT NEW ITEM --------------
	if(isset($_POST['submitNewItem']))
	{
		//SANITIZE title
		$_POST['itemTitle'] = filter_var($_POST['itemTitle'], FILTER_SANITIZE_STRING);
		//SANITIZE DESCRIPTION
		$_POST['itemDescription'] = filter_var($_POST['itemDescription'], FILTER_SANITIZE_STRING);
		//SANITIZE QUANTITY
		$_POST['itemQuantity'] = filter_var($_POST['itemQuantity'], FILTER_SANITIZE_STRING);
		//SANITIZE PRICE
		$_POST['itemPrice'] = filter_var($_POST['itemPrice'], FILTER_SANITIZE_STRING);

		//SANITIZE description
		if($_POST['itemDescription'] == "")
		{
			$errorMsg[] = "Description Cannot Be Blank";
		}
		if($_POST['itemTitle'] == "")
		{
			$errorMsg[] = "Title Cannot Be Blank";
		}
		if($_POST['itemQuantity'] == "")
		{
			$errorMsg[] = "Quantity Cannot Be Blank";
		}
		if($_POST['itemPrice'] == "")
		{
			$errorMsg[] = "Price Cannot Be Blank";
		}

		if(strlen($_POST['itemDescription']) < 2)
		{
			$errorMsg[] = "Description Must Be Equal To Or Longer Than 2 Characters";
		}


		if(!$errorMsg)
		{
			//upload header and store in database
			$target = "../uploads/shopImages/";
			$text = "image";
			$target .= basename($_FILES[$text]['name']);	
			$imageName = basename($_FILES[$text]['name']);
			
			move_uploaded_file($_FILES[$text]['tmp_name'], $target);

			//UPDATE DATABASE
			$sql = "INSERT INTO tblShop SET ";
			$sql .= "fldName='" . $_POST['itemTitle'] . "', ";
			$sql .= "fldQuantity='" . $_POST['itemQuantity'] . "', ";
			$sql .= "fldPrice='" . $_POST['itemPrice'] . "', ";
			$sql .= "fldDescription='" . $_POST['itemDescription'] . "', "; 
			$sql .= "fldImage='" . $imageName . "', ";
			$sql .= "fldBuyNow='" . $_POST['itemBuy'] . "'";
		    if(mysql_query($sql, $connectID))
		    {
		    	$succMsg[] = "Your Item Has Been Posted!";
		    }
		    else
		    {
		    	$errorMsg[] = "Something Went Wrong When Trying To Submit Your Item... Try Again";
		    }

		   	
		}

		if(!$errorMsg & $succMsg)
		{
			$_POST['itemTitle'] = "";
			$_POST['itemQuantity'] = "";
			$_POST['itemPrice'] = "";
			$_POST['itemDescription'] = "";
			$_POST['itemBuy'] = "";
		}
	}
	// ------------ REMOVE ITEM --------------
	if(isset($_POST['submitRemoveItem']))
	{
		if(!isset($_POST['itemPick']))
		{
			$errorMsg[] = "You Must Pick An Item To Remove!";
		}
		if(!$errorMsg)
		{
			$sql = "SELECT fldImage FROM tblShop WHERE pkItemID='" . $_POST['itemPick'] . "'";
			$myData = mysql_query($sql,$connectID);
			$imageRemove = mysql_fetch_array($myData);
			unlink("../uploads/shopImages/" . $imageRemove[0]);

			$sql2 = "DELETE FROM tblShop WHERE pkItemID='" . $_POST['itemPick'] . "'";
			if(mysql_query($sql2, $connectID))
			{
				$succMsg[] = "The Item Has Been Removed!";
				$succMsg[] = "The Item Images Had Been Removed";
			}
			else
			{
				$errorMsg[] = "Something Went Wrong When Trying To Remove Your Item, Try Again";
			}
		}
	}

	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// ---------------------G_E_N_E_R_A_A_L ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------



	// ------------ CHANGE HEADER --------------

	if(isset($_POST['changeHeader']))
	{
		if(!$_POST['cb'])
		{
			//SANITIZE Contact Phone
			if($_POST['phone'] == "")
			{
				$errorMsg[] = "phone Cannot Be Blank";
			}
			else
			{
				$_POST['phone'] = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
				if($_POST['phone'] == "")
				{
					$errorMsg[] = "Phone Number Cannot Be Blank";
				}
				elseif(!isNumeric($_POST['phone']))
				{
					$errorMsg[] = "Phone Number Must Be Just Numbers (FORMAT: xxxxxxxxxx)";
				}
				elseif(strlen($_POST['phone']) != 10)
				{
					$errorMsg[] = "Phone Number Must Be 10 Characters Long (FORMAT: xxxxxxxxxx)";
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

			//SANITIZE About
			if($_POST['about'] == "")
			{
				$errorMsg[] = "About Cannot Be Blank";
			}
			/*else
			{
				$_POST['about'] = filter_var($_POST['about'], FILTER_SANITIZE_STRING);
				if($_POST['about'] == "")
				{
					$errorMsg[] = "About Number Cannot Be Blank";
				}
				elseif(!verifyText($_POST['about']))
				{
					$errorMsg[] = "About Contains Illigal Characters (letters, numbers, !, ?, dashes, quotes)";
				}
			}*/

			if(!$errorMsg)
			{
				//DO NOT UPLOAD NEW IMAGE
				$sql = "UPDATE tblGeneral SET fldContactPhone='" . $_POST['phone'] . "', fldContactEmail='" . $_POST['email'] . "', fldAbout='" . $_POST['about'] . "'";
				if(mysql_query($sql, $connectID))
				{
					$succMsg[] = "Settings Updated!";
				}
				else
				{
					$errorMsg[] = "Something Went Wrong Trying To Change The Settings, Try Again";
				}
			}
		}
		else
		{
			//SANITIZE Contact Phone
			if($_POST['phone'] == "")
			{
				$errorMsg[] = "phone Cannot Be Blank";
			}
			else
			{
				$_POST['phone'] = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
				if($_POST['phone'] == "")
				{
					$errorMsg[] = "Phone Number Cannot Be Blank";
				}
				elseif(!isNumeric($_POST['phone']))
				{
					$errorMsg[] = "Phone Number Must Be Just Numbers (FORMAT: xxxxxxxxxx)";
				}
				elseif(strlen($_POST['phone']) != 10)
				{
					$errorMsg[] = "Phone Number Must Be 10 Characters Long (FORMAT: xxxxxxxxxx)";
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

			//SANITIZE About
			if($_POST['about'] == "")
			{
				$errorMsg[] = "About Cannot Be Blank";
			}
			else
			{
				$_POST['about'] = filter_var($_POST['about'], FILTER_SANITIZE_STRING);
				if($_POST['about'] == "")
				{
					$errorMsg[] = "About Number Cannot Be Blank";
				}
				elseif(!verifyText($_POST['about']))
				{
					$errorMsg[] = "About Contains Illigal Characters (letters, numbers, !, ?, dashes, quotes)";
				}
			}

			if(!$errorMsg)
			{
				//upload header and store in database
				$target = "../uploads/header/";
				$text = "headerFile";
				$target .= basename($_FILES[$text]['name']);	
				$imageName = basename($_FILES[$text]['name']);
				
				move_uploaded_file($_FILES[$text]['tmp_name'], $target);
				
				$sql = "UPDATE tblGeneral SET fldContactPhone='" . $_POST['phone'] . "', fldContactEmail='" . $_POST['email'] . "', fldAbout='" . $_POST['about'] . "', fldHeaderImage='" . $imageName . "'";

				if(mysql_query($sql, $connectID))
				{
					$succMsg[] = "Settings Updated!";
				}
				else
				{
					$errorMsg[] = "Something Went Wrong Trying To Change The Settings, Try Again";
				}
			}
		}
	}


	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------
	// --------------------- U_S_E_R ----- I_N_F_O_R_M_A_T_I_O_N ----------------------------


	// ------------ REMOVE USER --------------
	if(isset($_POST['submitRemoveUser']))
	{
		$string = $_POST['userPick'];
		$username = explode(" | ", $string);
		$sql = "DELETE FROM tblUsers WHERE fldUsername='" . $username[0] . "'";
		if($string == "" || $string == null)
		{
			$errorMsg[] = "You Must Select A Memeber To Remove";
		}
		if(!$errorMsg)
		{
			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "The User <span style='padding: 0px; margin: 0px; font-size: 20px; font-weight: bold;'>" . $username[0] . "</span>, Has Been Removed For Good...";
			}
			else
			{
				$errorMsg[] = "Something Went Wrong When Trying To Remove The User, Please Try Again or Contact Anders";
			}
		}
	}
	// --------------- UPGRADE USER ---------------
	if(isset($_POST['submitUpgradeUser']))
	{
		$string = $_POST['userPick'];
		$username = explode(" | ", $string);
		$sql = "UPDATE tblUsers SET fldAdminLevel=fldAdminLevel+1 WHERE fldUsername='" . $username[0] . "'";
		$sql2 = "SELECT fldAdminLevel FROM tblUsers WHERE fldUsername='" . $username[0] . "'";
		$temp2 = mysql_query($sql2, $connectID);
		$row2 = mysql_fetch_array($temp2);
		if($string == "" || $string == null)
		{
			$errorMsg[] = "You Must Select A Member To Upgrade";
		}
		elseif($row2[0] == 2)
		{
			$errorMsg[] = "You Cannot Upgrade This Member Any Further!";
		}
		if(!$errorMsg)
		{
			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "The User <span style='padding: 0px; margin: 0px; font-size: 20px; font-weight: bold;'>" . $username[0] . "</span>, Has Been Confirmed / Upgraded To Manager";
			}
			else
			{
				$errorMsg[] = "An Error Has Occured, Try Again Or Contact Anders If It Continues";
			}
		}
	}
	// --------------- DOWNGRADE USER ------------
	if(isset($_POST['submitDowngradeUser']))
	{
		$string = $_POST['userPick'];
		$username = explode(" | ", $string);
		$sql = "UPDATE tblUsers SET fldAdminLevel=fldAdminLevel-1 WHERE fldUsername='" . $username[0] . "'";
		$sql2 = "SELECT fldAdminLevel FROM tblUsers WHERE fldUsername='" . $username[0] . "'";
		$temp2 = mysql_query($sql2, $connectID);
		$row2 = mysql_fetch_array($temp2);
		if($string == "" || $string == null)
		{
			$errorMsg[] = "You Must Select A Member To Downgrade";
		}
		elseif($row2[0] == 0)
		{
			$errorMsg[] = "You Cannot Downgrade This Member Any Further!";
		}
		if(!$errorMsg)
		{
			if(mysql_query($sql, $connectID))
			{
				$succMsg[] = "The User <span style='padding: 0px; margin: 0px; font-size: 20px; font-weight: bold;'>" . $username[0] . "</span>, Has Been Downgraded... (Non-Confirmed Means Suspension)";
			}
			else
			{
				$errorMsg[] = "Something Went Wrong When Trying To Downgrade The Users Admin Level, Try Again or Contact Anders";
			}
		}
	}
	if(!isset($_SESSION['adminLevel']))
	{
		$_SESSION['adminLevel'] = 0;
	}


	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------
	// ------------------------------- END OF CONTROLLER -------------------------------

	if($_SESSION['adminLevel'] > 1 & $_SESSION['loggedIn'])
	{
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta name='author' content='Anders D Melen' />
	<meta name='description' content='Caked Snowboards - Get Gear, Join The Contest, GetWitIt' />
	<META NAME='Title' CONTENT='Caked Snowboards - Managers'>
	<meta name='keywords' content='snow, snowboarding, skate, skating, riding, skateboarding, caked, get wit it,  getwitit, contest, raffle, Dave, Tafur' />
	<link rel='stylesheet' href='mystyle.css' type='text/css' media='screen' />
	<link rel='stylesheet' href='button.css' type='text/css' media='screen' />
	
	<link rel='stylesheet' href='development-bundle/themes/base/jquery.ui.all.css'>";

	include("jquery.php");

echo "</head>
<body>
	<!-- -------------- FLOATING DIVS --------- -->
	<!-- -------------- MENU DIV ------------- -->";
	echo "<a name='top'></a>";
	include("menu.php"); 


	


		/*- ------------- HEADER ------------- */
		$sql = "SELECT fldHeaderImage FROM tblGeneral";
		$temp = mysql_query($sql, $connectID);
		$row = mysql_fetch_array($temp);
		$address = "../uploads/header/" . $row[0];

		echo "<div id='headerDiv' style='background-image:url(" . $address . ");'></div>


	<!-- ------------ BODY DIV --------- -->
	<div id='bodyDiv'>";
		




        // ---------------------- WELCOME TAB! ----------------------------
        echo "<div class='postDiv'>";
        echo "<div style='float: left; width: 580px;'>";
        echo "Welcome " . $_SESSION['fName'] . " " . $_SESSION['lName'] . ", Your Current username is " . $_SESSION['username'] . ". ";
        echo "To view your open orders, change your personal settings, or see your contest winnings check your user control panel located on the right.";
        echo "</div>";
        echo "<div style='float: right;'>";
        echo "<a href='logout.php' id='logoutDiv' class='button logout' style='float: right;'>Logout</a>";
        echo "</br>";
        echo "<a href='userCP.php' class='menuButton settings' style='margin:0px;'>User Control Panel</a>
        	</div>";
        	// -------------------- LOGIN / WELCOME DIV! --------------------------------
		echo "<div style='clear: both;'></div>";

        // ------------- SETTINGS SELECTOR! -----------------------

        echo "<hr>";
        echo "<a href='#analytics' style='margin: 0px; margin-left: 5px; padding-left: 1.5em; padding-right: 1em;' class='menuButton graph'>Analytics</a>";
        echo "<a href='#managers' style='margin: 0px; margin-left: 1px; padding-left: 1.5em; padding-right: 1em;' class='menuButton members'>Members</a>";
        echo "<a href='#post' style='margin: 0px; margin-left: 1px; padding-left: 1.5em; padding-right: 1em;' class='menubutton tack'>Posts</a>";
        echo "<a href='#contest' style='margin: 0px; margin-left: 1px; padding-left: 1.5em; padding-right: 1em;' class='menuButton trophy'>Contest</a>";
        echo "<a href='#shop' style='margin: 0px; margin-left: 1px; padding-left: 1.5em; padding-right: 1em;' class='menuButton tshirt'>Shop</a>";
        echo "<a href='#general' style='margin: 0px; margin-left: 1px; padding-left: 1.5em; padding-right: 1em;' class='menuButton settings'>General</a>";
        echo "</div>";


        // ---------------------- SITE ANALYTICS ---------------------------------

        echo "<div class='postDiv'>
        	<a name='analytics'></a>
        	<div style='float: left; margin: 0px; padding: 0px;'><h2>Google Analytics</h2></div>
			<div style='float: right; margin: 0px; padding: 0px;'><a href='#top' class='menuButton uparrow' style='margin:0px;'>Top</a></div>
			<div style='clear: both;'></div>
			<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
				<p>Here you have a ability to view all sorts of data about the people viewing your site. From number of unique visitors to the location of the viewer. Just sign in with the caked username and password and explore. Remeber the username and password then, click the link and sign in. Once signed in you will see a 'caked' folder, click it. Inside, you'll see another folder with a long name, click it. Inside that folder you'll see another caked folder, click it and your ready to go.</p>
				Username: popwarfour@hotmail.com </br>
				Password: getcaked </br>
				<a href='https://accounts.google.com/ServiceLogin?service=analytics&passive=true&nui=1&hl=en&continue=https%3A%2F%2Fwww.google.com%2Fanalytics%2Fweb%2F&followup=https%3A%2F%2Fwww.google.com%2Fanalytics%2Fweb%2F'>View My Google Analytics</a>
			</div>
		</div>";


        // ---------------------- MANAGERS CONTROL TAB! ----------------------------
		echo "<div class='postDiv'>
			<a name='managers'></a>
			<div style='float: left; margin: 0px; padding: 0px;'><h2>Memebers / Managers Control Zone</h2></div>
			<div style='float: right; margin: 0px; padding: 0px;'><a href='#top' class='menuButton uparrow' style='margin:0px;'>Top</a></div>
			<div style='clear: both;'></div>

			<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>

				<form action='" . $_SERVER["PHP_SELF"] . "#managers' method='post' class='noMargin'>";
				$sql = "SELECT count(fldUsername) AS fldCount FROM tblUsers WHERE fldAdminLevel='0'";
	        	$temp = mysql_query($sql, $connectID);
	        	$row = mysql_fetch_array($temp);
	        	echo "<h3>Non-Confirmed Memebers List | " . $row[0] . " Non-Confirmed Members</h3>
	        	<h4> Username | Full Name | Email Address | Date Joined </h4>";

	        	$sql2 = "SELECT fldUsername, fldFName, fldLName, fldEmail, fldDateJoin FROM tblUsers WHERE fldAdminLevel='0' ORDER BY fldDateJoin DESC";
	        	$temp2 = mysql_query($sql2, $connectID);
				echo "<select id='userPick' name='userPick' size='10' style='width: 500px;'>";
		        	while($row2 = mysql_fetch_array($temp2))
		        	{
		        		echo "<option><div>" . $row2[0] . " | " . $row2[1] . " " . $row2[2] . " | " . $row2[3] . " | " . $row2[4] . "</div></option>";
		        	}
			    echo "</select>
			    </br>
			    <input type='submit' class='button' name='submitRemoveUser' id='submitRemoveUser' value='Remove User'/>
			    <input type='submit' class='button' name='submitUpgradeUser' id='submitUpgradeUser' value='Auto Confirm User'/>
			    </form>
			</div>

			<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
			    <form action='" . $_SERVER["PHP_SELF"] . "#managers' method='post' class='noMargin'>";
	        	$sql = "SELECT count(fldUsername) AS fldCount FROM tblUsers WHERE fldAdminLevel='1'";
	        	$temp = mysql_query($sql, $connectID);
	        	$row = mysql_fetch_array($temp);
	        	echo "<h3>Members List | " . $row[0] . " Current Members</h3>
	        	<h4> Username | Full Name | Email Address | Date Joined </h4>";

	        	$sql2 = "SELECT fldUsername, fldFName, fldLName, fldEmail, fldDateJoin FROM tblUsers WHERE fldAdminLevel='1' ORDER BY fldDateJoin DESC";
	        	$temp2 = mysql_query($sql2, $connectID);
				echo "<select id='userPick' name='userPick' size='10' style='width: 500px;'>";
		        	while($row2 = mysql_fetch_array($temp2))
		        	{
		        		echo "<option><div>" . $row2[0] . " | " . $row2[1] . " " . $row2[2] . " | " . $row2[3] . " | " . $row2[4] . "</div></option>";
		        	}
			    echo "</select>
			    </br>
			    <input type='submit' class='button' name='submitRemoveUser' id='submitRemoveUser' value='Remove User'/>
			    <input type='submit' class='button' name='submitUpgradeUser' id='submitUpgradeUser' value='Make User a Manager'/>
			    <input type='submit' class='button' name='submitDowngradeUser' id='submitDowngradeUser' value='Downgrade User'/>
			    </form>
			</div>

			<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
			    <form action='" . $_SERVER["PHP_SELF"] . "#managers' method='post' class='noMargin'>";
	        	$sql = "SELECT count(fldUsername) AS fldCount FROM tblUsers WHERE fldAdminLevel='2'";
	        	$temp = mysql_query($sql, $connectID);
	        	$row = mysql_fetch_array($temp);
	        	echo "<h3>Managers List | " . $row[0] . " Current Managers</h3>
	        	<h4> Username | Full Name | Email Address | Date Joined </h4>";
	        	$sql2 = "SELECT fldUsername, fldFName, fldLName, fldEmail, fldDateJoin FROM tblUsers WHERE fldAdminLevel='2' ORDER BY fldDateJoin DESC";
	        	$temp2 = mysql_query($sql2, $connectID);
				echo "<select id='userPick' name='userPick' size='10' style='width: 500px;'>";
		        	while($row2 = mysql_fetch_array($temp2))
		        	{
		        		echo "<option><div>" . $row2[0] . " | " . $row2[1] . " " . $row2[2] . " | " . $row2[3] . " | " . $row2[4] . "</div></option>";
		        	}
			    echo "</select>
			    </br>
			   	<input type='submit' class='button' name='submitRemoveUser' id='submitRemoveUser' value='Remove User'/>
			   	<input type='submit' class='button' name='submitDowngradeUser' id='submitDowngradeUser' value='Downgrade User'/>
			   	</form>
		   	</div>
		</div>";




		 // ---------------------- POST CONTROL TAB! ----------------------------
		echo "<div class='postDiv'>
				<a name='post'></a>
				<div style='float: left; margin: 0px; padding: 0px;'><h2>Managers Post Control Zone</h2></div>
				<div style='float: right; margin: 0px; padding: 0px;'><a href='#top' class='menuButton uparrow' style='margin:0px;'>Top</a></div>
				<div style='clear: both;'></div>
				<div style='border: 1px solid black; float: left; width: 50%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
				if(isset($_POST['submitEditPost']))
				{
					if(!isset($_POST['postPick']))
					{
						$errorMsg[] = "You Must Pick A Post To Edit";
					}

					if(!$errorMsg)
					{
						$sql = "SELECT count(pkPostID) AS fldCount FROM tblPosts";
			        	$temp = mysql_query($sql, $connectID);
			        	$row = mysql_fetch_array($temp);
			        	echo "<h3>Managers Posts | " . $row[0] . " Total Managers Posts</h3>
			        	<h4> Poster's Username | Post Title | Date Posted | Time Posted </h4>";
			        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#post' method='post' class='noMargin'>";
			        	$sql2 = "SELECT fldUsername, fldTitle, fldDate, fldTime, pkPostID FROM tblPosts ORDER BY pkPostID DESC";
			        	$temp2 = mysql_query($sql2, $connectID);
						echo "<select name='postPick' id='postPick' size='10'>";
				        	while($row2 = mysql_fetch_array($temp2))
				        	{
				        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
				        	}
					    echo "</select>
					    	</br>
					    	<input type='submit' class='button' name='submitRemovePost' id='submitRemovePost' value='Remove Post'/>
					    	<input type='submit' class='button' name='submitEditPost' id='submitEditPost' value='Edit Post'/>
					    </form>
					    </div>";


					    echo "<div style='border: 1px solid black; float: left; width: 39%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					    $sql = "SELECT fldTitle, fldDescription FROM tblPosts WHERE pkPostID='" . $_POST['postPick'] . "'";
					    $temp = mysql_query($sql, $connectID);
					    $row = mysql_fetch_array($temp);
					    echo "<h3>Edit Post</h3>
					    <form action='" . $_SERVER['PHP_SELF'] . "#post' method='post' class='noMargin'>
					    	<label>Title</label>
					    	</br>
					    	<input size='45' type='text' name='title' id='title' value='" . $row[0] . "'/>
					    	</br>
					    	<label>Description</label>
					    	</br>
					    	<textarea name='description' id='description' cols='35' rows='10'>";
					    	echo $row[1];
					    	echo "</textarea>
					    	</br>
					    	<input type='submit' class='button' value='Resubmit Post' name='resubmitPost' id='resubmitPost'/>
					    	<input type='hidden' name='postPick' id='postPick' value='" . $_POST['postPick'] . "'/>
					    </form>
					    </div>
						<div style='clear: both;'></div>";
					}
					else
					{
						echo "JAH MESSAGE" . $errorMsg[0];
						$sql = "SELECT count(pkPostID) AS fldCount FROM tblPosts";
			        	$temp = mysql_query($sql, $connectID);
			        	$row = mysql_fetch_array($temp);
			        	echo "<h3>Managers Posts | " . $row[0] . " Total Managers Posts</h3>
			        	<h4> Poster's Username | Post Title | Date Posted | Time Posted </h4>";
			        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#post' method='post' class='noMargin'>";
			        	$sql2 = "SELECT fldUsername, fldTitle, fldDate, fldTime, pkPostID FROM tblPosts ORDER BY pkPostID DESC";
			        	$temp2 = mysql_query($sql2, $connectID);
						echo "<select name='postPick' id='postPick' size='10'>";
				        	while($row2 = mysql_fetch_array($temp2))
				        	{
				        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
				        	}
						    echo "</select>
						    	</br>
						    	<input type='submit' class='button' name='submitRemovePost' id='submitRemovePost' value='Remove Post'/>
						    	<input type='submit' class='button' name='submitEditPost' id='submitEditPost' value='Edit Post'/>
						    </form>
					    </div>


					    <div style='border: 1px solid black; float: left; width: 39%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>

						    <h3>Make a New Post</h3>
						    <form enctype='multipart/form-data' action='" . $_SERVER['PHP_SELF'] . "#post' method='post' class='noMargin'>
						    	<label>Title</label>
						    	</br>
						    	<input size='45' type='text' name='title' id='title' value=''/>
						    	</br>
						    	<label>Description</label>
						    	</br>
						    	<textarea name='description' id='description' cols='35' rows='10'></textarea>
						    	</br>
						    	<label>Image 1:</label>
				                <input type='file' name='image1' id='image1' size='30' maxlength='255'/> 
				                </br>
				                <label>Image 2:</label>
				                <input type='file' name='image2' id='image2' size='30' maxlength='255'/> 
				                <input type='hidden' name='postPick' id='postPick' value='" . $_POST['postPick'] . "'/>
						    	</br>
						    	</br>
						    	<input type='submit' class='button' value='Submit New Post' name='submitPost' id='submitPost'/>
						    </form>
						</div>
						<div style='clear: both;'></div>";
					}
				}
				else
				{
					$sql = "SELECT count(pkPostID) AS fldCount FROM tblPosts";
		        	$temp = mysql_query($sql, $connectID);
		        	$row = mysql_fetch_array($temp);
		        	echo "<h3>Managers Posts | " . $row[0] . " Total Managers Posts</h3>
		        	<h4> Poster's Username | Post Title | Date Posted | Time Posted </h4>";
		        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#post' method='post' class='noMargin'>";
		        	$sql2 = "SELECT fldUsername, fldTitle, fldDate, fldTime, pkPostID FROM tblPosts ORDER BY pkPostID DESC";
		        	$temp2 = mysql_query($sql2, $connectID);
					echo "<select name='postPick' id='postPick' size='10'>";
			        	while($row2 = mysql_fetch_array($temp2))
			        	{
			        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
			        	}
				    echo "</select>
				    	</br>
				    	<input type='submit' class='button' name='submitRemovePost' id='submitRemovePost' value='Remove Post'/>
				    	<input type='submit' class='button' name='submitEditPost' id='submitEditPost' value='Edit Post'/>
				    </form>
			    </div>


			    <div style='border: 1px solid black; float: left; width: 39%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>

				    <h3>Make a New Post</h3>";
				    if(!$errorMsg)
				    {
				    	echo "<form enctype='multipart/form-data' action='" . $_SERVER['PHP_SELF'] . "#post' method='post' class='noMargin'>
				    	<label>Title</label>
				    	</br>
				    	<input size='45' type='text' name='title' id='title' value=''/>
				    	</br>
				    	<label>Description</label>
				    	</br>
				    	<textarea name='description' id='description' cols='35' rows='10'></textarea>
				    	</br>
				    	<label>Image 1:</label>
		                <input type='file' name='image1' id='image1' size='30' maxlength='255'/> 
		                </br>
		                <label>Image 2:</label>
		                <input type='file' name='image2' id='image2' size='30' maxlength='255'/> 
		                
				    	</br>
				    	</br>
				    	<input type='submit' class='button' value='Submit New Post' name='submitPost' id='submitPost'/>
				    	</form>";
				    }
				    else
				    {


					    echo "<form enctype='multipart/form-data' action='" . $_SERVER['PHP_SELF'] . "#post' method='post' class='noMargin'>
					    	<label>Title</label>
					    	</br>
					    	<input size='45' type='text' name='title' id='title' value='" . $_POST['title'] . "'/>
					    	</br>
					    	<label>Description</label>
					    	</br>
					    	<textarea name='description' id='description' cols='35' rows='10'>" . $_POST['description'] . "</textarea>
					    	<input type='hidden' name='postPick' id='postPick' value='" . $_POST['postPick'] . "'/>
					    	</br>
					    	<label>Image 1:</label>
			                <input type='file' name='image1' id='image1' size='30' maxlength='255'/> 
			                </br>
			                <label>Image 2:</label>
			                <input type='file' name='image2' id='image2' size='30' maxlength='255'/> 
			                
					    	</br>
					    	</br>
					    	<input type='submit' class='button' value='Submit New Post' name='submitPost' id='submitPost'/>
					    </form>";
					}
				echo "</div>
				<div style='clear: both;'></div>";
			}
	echo "</div>";




	// ---------------------- CONTEST / RAFFLE TAB! ----------------------------
	echo "<div class='postDiv'>
			<a name='contest'></a>
			<div style='float: left; margin: 0px; padding: 0px;'><h2>Contest Management Zone</h2></div>
			<div style='float: right; margin: 0px; padding: 0px;'><a href='#top' class='menuButton uparrow' style='margin:0px;'>Top</a></div>
			<div style='clear: both;'></div>";


			if(isset($_POST['submitEditContest']))
			{
				if(!isset($_POST['contestPick']))
				{
					$errorMsg[] = "You Must Pick A Contest To Edit";
				}
				if(!$errorMsg)
				{
					// ---------------------------------------------------------
					// -------------- IF EDITED WITHOUT ERROR ------------------
					// ---------------------------------------------------------
					echo "<div style='border: 1px solid black; float: left; width: 55%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					$sql = "SELECT count(pkContestID) AS fldCount FROM tblContest";
		        	$temp = mysql_query($sql, $connectID);
		        	$row = mysql_fetch_array($temp);
		        	echo "<h3>Live Contests | " . $row[0] . " Total Live Contests</h3>

		        	<h4> Starters Username | Contest Title | Date Started | Date Ended </h4>";

		        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#contest' method='post' class='noMargin'>";
		        	$sql2 = "SELECT fkUsername, fldTitle, fldStartDate, fldEndDate, pkContestID FROM tblContest ORDER BY pkContestID DESC";
		        	$temp2 = mysql_query($sql2, $connectID);
					echo "<select name='contestPick' id='contestPick' size='10' style='width: 450px;'>";
			        	while($row2 = mysql_fetch_array($temp2))
			        	{
			        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
			        	}
				    echo "</select>
				    	</br>
				    	<input type='submit' class='button' name='submitRemoveContest' id='submitRemoveContest' value='Remove Contest'/>
				    	<input type='submit' class='button' name='submitEditContest' id='submitEditContest' value='Edit Contest'/>
				    </form>
				    </div>

				    <div style='border: 1px solid black; float: left; width: 34%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";

					    $sql3 = "SELECT fkUsername, fldTitle, fldStartDate, fldEndDate, fldDescription FROM tblContest WHERE pkContestID='" . $_POST['contestPick'] . "'";
					
					    $temp3 = mysql_query($sql3, $connectID);
					    $row3 = mysql_fetch_array($temp3);

					    echo "<h3>Edit Contest</h3>
						<form action='" . $_SERVER['PHP_SELF'] . "#contest' method='post' class='noMargin'>
			                <label>Contest Title</label>
			                </br>
			                <input type='text' name='contestTitle' id='contestTitle' size='40' value='" . $row3[1] . "'/>
			                </br>
			                <label>Contest Description</label>
			                </br>
			                <input type='hidden' name='contestPick' id='contestPick' value='" . $_POST['contestPick'] . "'/>
			                <textarea name='contestDescription' id='contestDescription' cols='30' rows='10'>" . $row3[4] . "</textarea>
						    	</br>";

						    $contestStartDate = DATE("m/d/Y", STRTOTIME($row3[2]));
						    $contestEndDate = DATE("m/d/Y", STRTOTIME($row3[3]));

						    echo "<label>Starting Date:</label>
						    <input name='contestStartDate' class='datePicker' type='text' value='" . $contestStartDate . "'>
						    </br>

						    <label>Ending Date:</label>
						    <input name='contestEndDate' class='datePicker' type='text' value='" . $contestEndDate . "'>
						    
							<input type='submit' class='button' name='resubmitNewContest' id='resubmitNewContest' value='Resubmit Contest'/>
						</form>
					</div>
					<div style='clear: both;'></div>";
				}
				else
				{
					// ---------------------------------------------------------
					// -------------- IF EDITED WITH ERRORS! -------------------
					// ---------------------------------------------------------
					echo "<div style='border: 1px solid black; float: left; width: 55%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					$sql = "SELECT count(pkContestID) AS fldCount FROM tblContest";
		        	$temp = mysql_query($sql, $connectID);
		        	$row = mysql_fetch_array($temp);
		        	echo "<h3>Live Contests | " . $row[0] . " Total Live Contests</h3>

		        	<h4> Starters Username | Contest Title | Date Started | Date Ended </h4>";

		        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#contest' method='post' class='noMargin'>";
		        	$sql2 = "SELECT fkUsername, fldTitle, fldStartDate, fldEndDate, pkContestID FROM tblContest ORDER BY pkContestID DESC";
		        	$temp2 = mysql_query($sql2, $connectID);
					echo "<select name='contestPick' id='contestPick' size='10' style='width: 450px;'>";
			        	while($row2 = mysql_fetch_array($temp2))
			        	{
			        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
			        	}
				    echo "</select>
				    	</br>
				    	<input type='submit' class='button' name='submitRemoveContest' id='submitRemoveContest' value='Remove Contest'/>
				    	<input type='submit' class='button' name='submitEditContest' id='submitEditContest' value='Edit Contest'/>
				    </form>
				    </div>

				    <div style='border: 1px solid black; float: left; width: 34%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					    <h3>Create A New Contest</h3>
						<form action='" . $_SERVER['PHP_SELF'] . "#contest' method='post' class='noMargin'>
			                <label>Contest Title</label>
			                </br>
			                <input type='text' name='contestTitle' id='contestTitle' size='40' value=''/>
			                </br>
			                <label>Contest Description</label>
			                </br>
			                <textarea name='contestDescription' id='contestDescription' cols='30' rows='10'></textarea>
						    	</br>

						    <label>Starting Date:</label>
						    <input name='contestStartDate' class='datePicker' type='text'>
						    </br>

						    <input type='hidden' name='contestPick' id='contestPick' value='" . $_POST['contestPick'] . "'/>
						    <label>Ending Date:</label>
						    <input name='contestEndDate' class='datePicker' type='text'>
						    

							<input type='submit' class='button' name='submitNewContest' id='submitNewContest' value='Start New Contest'/>
						</form>
					</div>
					<div style='clear: both;'></div>";
				}
			}
			else
			{
				echo "<div style='border: 1px solid black; float: left; width: 55%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					$sql = "SELECT count(pkContestID) AS fldCount FROM tblContest";
		        	$temp = mysql_query($sql, $connectID);
		        	$row = mysql_fetch_array($temp);
		        	echo "<h3>Live Contests | " . $row[0] . " Total Live Contests</h3>

		        	<h4> Starters Username | Contest Title | Date Started | Date Ended </h4>";

		        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#contest' method='post' class='noMargin'>";
		        	$sql2 = "SELECT fkUsername, fldTitle, fldStartDate, fldEndDate, pkContestID FROM tblContest ORDER BY pkContestID DESC";
		        	$temp2 = mysql_query($sql2, $connectID);
					echo "<select name='contestPick' id='contestPick' size='10' style='width: 450px;'>";
			        	while($row2 = mysql_fetch_array($temp2))
			        	{
			        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
			        	}
				    echo "</select>
				    	</br>
				    	<input type='submit' class='button' name='submitRemoveContest' id='submitRemoveContest' value='Remove Contest'/>
				    	<input type='submit' class='button' name='submitEditContest' id='submitEditContest' value='Edit Contest'/>
				    </form>
			    </div>

			    <div style='border: 1px solid black; float: left; width: 34%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
				    <h3>Create A New Contest</h3>";
				    if(!$errorMsg)
				    {
				    	echo "<form action='" . $_SERVER['PHP_SELF'] . "#contest' method='post' class='noMargin'>
		                <label>Contest Title</label>
		                </br>
		                <input type='text' name='contestTitle' id='contestTitle' size='40' value=''/>
		                </br>
		                <label>Contest Description</label>
		                </br>
		                <textarea name='contestDescription' id='contestDescription' cols='30' rows='10'></textarea>
					    	</br>

					    <label>Starting Date:</label>
					    <input name='contestStartDate' class='datePicker' type='text'>
					    </br>

					    <label>Ending Date:</label>
					    <input name='contestEndDate' class='datePicker' type='text'>
					    

						<input type='submit' class='button' name='submitNewContest' id='submitNewContest' value='Start New Contest'/>
						</form>";
				    }
				    else
				    {
				    	echo "<form action='" . $_SERVER['PHP_SELF'] . "#contest' method='post' class='noMargin'>
		                <label>Contest Title</label>
		                </br>
		                <input type='hidden' name='contestPick' id='contestPick' value='" . $_POST['contestPick'] . "'/>
		                <input type='text' name='contestTitle' id='contestTitle' size='40' value='" . $_POST['contestTitle'] . "'/>
		                </br>
		                <label>Contest Description</label>
		                </br>
		                <textarea name='contestDescription' id='contestDescription' cols='30' rows='10'>" . $_POST['contestDescription'] . "</textarea>
					    	</br>

					    <label>Starting Date:</label>
					    <input name='contestStartDate' class='datePicker' type='text' value='" . $_POST['contestStartDate'] . "'>
					    </br>

					    <label>Ending Date:</label>
					    <input name='contestEndDate' class='datePicker' type='text' value='" . $_POST['contestEndDate'] . "'>
					    
					    </br>
						<input type='submit' class='button' name='resubmitNewContest' id='resubmitNewContest' value='Resubmit Contest'/>
						</form>";
				    }
					
				echo "</div>
				<div style='clear: both;'></div>";
			}
		echo "</div>";


	// ---------------------- SHOPPING TAB! ----------------------------
	echo "<div class='postDiv'>
			<a name='shop'></a>
			<div style='float: left; margin: 0px; padding: 0px;'><h2>Shopping Control Center</h2></div>
			<div style='float: right; margin: 0px; padding: 0px;'><a href='#top' class='menuButton uparrow' style='margin:0px;'>Top</a></div>
			<div style='clear: both;'></div>";

			if(isset($_POST['submitEditItem']))
			{
				// -------------------------------------------------------
				// -------------------- IF EDITED ------------------------
				// -------------------------------------------------------
				if(!isset($_POST['itemPick']))
				{
					$errorMsg[] = "You Must Pick A Item To Edit";
				}

				if(!$errorMsg)
				{
					// -------------------------------------------------------
					// ----------------- IF EDITED WITH NO ERROR -------------
					// -------------------------------------------------------
					echo "<div style='border: 1px solid black; float: left; width: 55%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					$sql = "SELECT count(pkItemID) AS fldCount FROM tblShop";
		        	$temp = mysql_query($sql, $connectID);
		        	$row = mysql_fetch_array($temp);
		        	echo "<h3>Live Items | " . $row[0] . " Total Live Items</h3>

		        	<h4> Item Name | Quantity | Price | Description </h4>";

		        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#shop' method='post' class='noMargin'>";
		        	$sql2 = "SELECT fldName, fldQuantity, fldPrice, fldDescription, pkItemID FROM tblShop ORDER BY pkItemID DESC";
		        	$temp2 = mysql_query($sql2, $connectID);
					echo "<select name='itemPick' id='itemPick' size='10' style='width: 450px;'>";
			        	while($row2 = mysql_fetch_array($temp2))
			        	{
			        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
			        	}
				    echo "</select>
				    	</br>
				    	<input type='submit' class='button' name='submitRemoveItem' id='submitRemoveItem' value='Remove Item'/>
				    	<input type='submit' class='button' name='submitEditItem' id='submitEditItem' value='Edit Item'/>
				    </form>
				    </div>";

				    //GATHER THE ITEM DATA FROM THE SERVER THAT THE USER REQUESTED TO EDIT
				    $sql101 = "SELECT fldName, fldQuantity, fldPrice, fldDescription, fldBuyNow FROM tblShop WHERE pkItemID='" . $_POST['itemPick'] . "'";
				    $temp101 = mysql_query($sql101, $connectID);
				    $row101 = mysql_fetch_array($temp101);

				    echo "<div style='border: 1px solid black; float: left; width: 34%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";

					    echo "<h3>Edit Item</h3>
						<form action='" . $_SERVER['PHP_SELF'] . "#shop' method='post' class='noMargin'>
			                <label>Item Title</label>
			                </br>
			                <input type='text' name='itemTitle' id='itemTitle' size='40' value='" . $row101[0] . "'/>
			                </br>
			                <label>Item Quantity</label>
			                </br>
			                <input type='text' name='itemQuantity' id='itemQuantity' size='40' value='" . $row101[1] . "'/>
			                </br>
			                <label>Item Price</label>
			                </br>
			                <input type='text' name='itemPrice' id='itemPrice' size='40' value='" . $row101[2] . "'/>
			                </br>
			                <label>Item Description</label>
			               	</br>
			                <textarea name='itemDescription' id='itemDescription' cols='30' rows='10'>" . $row101[3] . "</textarea>
			                <input type='hidden' name='itemPick' id='itemPick' value='" . $_POST['itemPick'] . "'/>			             
			               	</br>
			                <label>Pay-Pal Code (<a href='https://www.paypal.com/cgi-bin/marketingweb?cmd=_login-run'>Get Code!</a>)<label>
			                </br>
			                <input type='text' name='itemBuy' id='itemBuy' size='30' value='" . $row101[4] . "'/>
						    </br>
							<input type='submit' class='button' name='resubmitNewItem' id='resubmitNewItem' value='Resubmit Item'/>
						</form>
					</div>
					<div style='clear: both;'></div>";
				}
				else
				{
					// -------------------------------------------------------
					// ----------------- IF EDITED WITH ERROR! ---------------
					// -------------------------------------------------------
					echo "<div style='border: 1px solid black; float: left; width: 55%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					$sql = "SELECT count(pkItemID) AS fldCount FROM tblShop";
		        	$temp = mysql_query($sql, $connectID);
		        	$row = mysql_fetch_array($temp);
		        	echo "<h3>Live Items | " . $row[0] . " Total Live Live</h3>

		        	<h4> Item Name | Quantity | Price | Description </h4>";

		        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#shop' method='post' class='noMargin'>";
		        	$sql2 = "SELECT fldName, fldQuantity, fldPrice, fldDescription, pkItemID FROM tblShop ORDER BY pkItemID DESC";
		        	$temp2 = mysql_query($sql2, $connectID);
					echo "<select name='itemPick' id='itemPick' size='10' style='width: 450px;'>";
			        	while($row2 = mysql_fetch_array($temp2))
			        	{
			        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
			        	}
				    echo "</select>
				    	</br>
				    	<input type='submit' class='button' name='submitRemoveItem' id='submitRemoveItem' value='Remove Item'/>
				    	<input type='submit' class='button' name='submitEditItem' id='submitEditItem' value='Edit Item'/>
				    </form>
				    </div>

				    <div style='border: 1px solid black; float: left; width: 34%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
					    <h3>Create A Item</h3>
						<form action='" . $_SERVER['PHP_SELF'] . "#shop' method='post' class='noMargin'>
			                <label>Item Title</label>
			                </br>
			                <input type='text' name='itemTitle' id='itemTitle' size='40' value=''/>
			                </br>
			                <label>Item Quantity</label>
			                </br>
			                <input type='text' name='itemQuantity' id='itemQuantity' size='40' value=''/>
			                </br>
			                <label>Item Price</label>
			                </br>
			                <input type='text' name='itemPrice' id='itemPrice' size='40' value=''/>
			                </br>
			                <label>Item Description</label>
			               	</br>
			                <textarea name='itemDescription' id='itemDescription' cols='30' rows='10'></textarea>
			                <input type='hidden' name='itemPick' id='itemPick' value=''/>
			                </br>
			                <label>Pay-Pal Code (<a href='https://www.paypal.com/cgi-bin/marketingweb?cmd=_login-run'>Get Code!</a>)<label>
				            </br>
			                <input type='text' name='itemBuy' size='30' id='itemBuy' value=''/>
						    </br>
							<input type='submit' class='button' name='submitNewItem' id='submitNewItem' value='Submit Item'/>
						</form>
					</div>
					<div style='clear: both;'></div>";
				}
			}
			else
			{
				// -------------------------------------------------------
				// ----------------- IF NOT EDITED -----------------------
				// -------------------------------------------------------
				echo "<div style='border: 1px solid black; float: left; width: 55%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";
					$sql = "SELECT count(pkItemID) AS fldCount FROM tblShop";
		        	$temp = mysql_query($sql, $connectID);
		        	$row = mysql_fetch_array($temp);
		        	echo "<h3>Live Items | " . $row[0] . " Total Live Live</h3>

		        	<h4> Item Name | Quantity | Price | Description </h4>";

		        	echo "<form action '" . $_SERVER['PHP_SELF'] . "#shop' method='post' class='noMargin'>";
		        	$sql2 = "SELECT fldName, fldQuantity, fldPrice, fldDescription, pkItemID FROM tblShop ORDER BY pkItemID DESC";
		        	$temp2 = mysql_query($sql2, $connectID);
					echo "<select name='itemPick' id='itemPick' size='10' style='width: 450px;'>";
			        	while($row2 = mysql_fetch_array($temp2))
			        	{
			        		echo "<option value='" . $row2[4] . "'><div>" . $row2[0] . " | " . $row2[1] . " | " . $row2[2] . " | " . $row2[3] . "</div></option>";
			        	}
				    echo "</select>
				    	</br>
				    	<input type='submit' class='button' name='submitRemoveItem' id='submitRemoveItem' value='Remove Item'/>
				    	<input type='submit' class='button' name='submitEditItem' id='submitEditItem' value='Edit Item'/>
				    </form>
				    </div>

				    <div style='border: 1px solid black; float: left; width: 34%; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>";

				    	// ----------------- IF NO ERRORS WITH NEW SUBMIT -----------------------
				    	if(!$errorMsg)
				    	{
						    echo "<h3>New Item</h3>
							<form enctype='multipart/form-data' action='" . $_SERVER['PHP_SELF'] . "#shop' method='post' class='noMargin'>
				                <label>Item Title</label>
				                </br>
				                <input type='text' name='itemTitle' id='itemTitle' size='40' value=''/>
				                </br>
				                <label>Item Quantity</label>
				                </br>
				                <input type='text' name='itemQuantity' id='itemQuantity' size='40' value=''/>
				                </br>
				                <label>Item Price</label>
				                </br>
				                <input type='text' name='itemPrice' id='itemPrice' size='40' value=''/>
				                </br>
				                <label>Item Description</label>
				               	</br>
				                <textarea name='itemDescription' id='itemDescription' cols='30' rows='10'></textarea>
							    </br>
						    	<label>Image</label>
				                <input type='file' name='image' id='image' size='25' maxlength='255'/> 
				                </br>
				                <label>Pay-Pal Code (<a href='https://www.paypal.com/cgi-bin/marketingweb?cmd=_login-run'>Get Code!</a>)<label>
				                </br>
				                <input type='text' name='itemBuy' size='30' id='itemBuy' value=''/>
							    </br>
								<input type='submit' class='button' name='submitNewItem' id='submitNewItem' value='Submit Item'/>
							</form>";
						}
						else
						{
						// ----------------- IF ERRORS WHEN DOING NEW SUBMIT -----------------------
							echo "<h3>New Item</h3>
							<form action='" . $_SERVER['PHP_SELF'] . "#shop' method='post' class='noMargin'>
				                <label>Item Title</label>
				                </br>
				                <input type='text' name='itemTitle' id='itemTitle' size='40' value='" . $_POST['itemTitle'] . "'/>
				                </br>
				                <label>Item Quantity</label>
				                </br>
				                <input type='text' name='itemQuantity' id='itemQuantity' size='40' value='" . $_POST['itemQuantity'] . "'/>
				                </br>
				                <label>Item Price</label>
				                </br>
				                <input type='text' name='itemPrice' id='itemPrice' size='40' value='" . $_POST['itemPrice'] . "'/>
				                </br>
				                <label>Item Description</label>
				               	</br>
				                <textarea name='itemDescription' id='itemDescription' cols='30' rows='10'>" . $_POST['itemDescription'] . "</textarea>
				                </br>
				                <label>Pay-Pal Code (<a href='https://www.paypal.com/cgi-bin/marketingweb?cmd=_login-run'>Get Code!</a>)<label>
				                </br>
				                <input type='text' name='itemBuy' size='30' id='itemBuy' value='" . $_POST['itemBuy'] . "'/>
							    </br>

							    <input type='hidden' name='itemPick' id='itemPick' value='" . $_POST['itemPick'] . "'/>
								<input type='submit' class='button' name='resubmitNewItem' id='resubmitNewItem' value='Resubmit Item'/>
							</form>";
						}
					echo "</div>
					<div style='clear: both;'></div>";
			}
		echo "</div>";

	


	// ---------------------- GENERAL SETTINGS TAB! ----------------------------

	$sql = "SELECT fldContactPhone, fldContactEmail, fldAbout FROM tblGeneral";
	$temp = mysql_query($sql, $connectID);
	$row = mysql_fetch_array($temp);

	echo "<div class='postDiv'>
			<a name='general'></a>
			<div style='float: left; margin: 0px; padding: 0px;'><h2>General Site Settings</h2></div>
			<div style='float: right; margin: 0px; padding: 0px;'><a href='#top' class='menuButton uparrow' style='margin:0px;'>Top</a></div>
			<div style='clear: both;'></div>

			<div style='border: 1px solid black; margin: 10px; padding: 10px; background-color: #CCCCCC; box-shadow:inset 0px 0px 10px black; border-radius: 10px 10px 10px 10px;'>
				<h3>Header Image</h3>
				<form enctype='multipart/form-data' action='" . $_SERVER['PHP_SELF'] . "' method='post' class='noMargin'>
	                <label>Header Image:</label>
	                </br>
	                <input type='file' name='headerFile' id='headerFile' size='30' maxlength='255'/> 
	                </br>
	                <input type='checkbox' name='cb' id='cb' value='catsndogs'/>
	                <label><span style='font-size: 12px; color: red;'>Check Here To Replace Current Header Image *WARNING* OLD IMAGE WILL BE DELETED / MUST BE 150px X 1000px TO FIT RIGHT</span></label>
			    	</br>
			    	<h3>Contact Information</h3>
			    	<label>Email Contact</label>
			    	</br>
			    	<input type='text' size='30' name='email' id='email' value='" . $row[1] . "'/>
			    	</br>
			    	<label>Phone Contact</label>
			    	</br>
			    	<input type='text' maxlength='10' size='15' name='phone' id='phone' value='" . $row[0] . "'/>
			    	</br>
			    	<h3>About Information</h3>
			    	<textarea cols='50' rows='10' name='about' id='about'>" . $row[2] . "</textarea>
			    	</br>
			    	<input type='submit' class='button' value='Change Settings' name='changeHeader' id='changeHeader'/>
			    </form>
			</div>
		</div>
	</div> <!-- ------------ END BODY ------------- -->
<div id='footerDiv'>
		<center>
		Site Created By: ADM Designs &copy; 2012 | For More Information Visit My Page at <a href='http://www.uvm.edu/~amelen/cs142/assign5/index.php'>ADM Web Designs</a>
		</center>	
	</div>


	
	</body>
	</html>";

		//SHOW ERROR MESSAGE!
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


	}
	else
	{
		//INCLUDE ERROR PAGE!
		echo "YOU DO NOT HAVE PERMISSION TO VIEW THIS PAGE";
	}
?>

