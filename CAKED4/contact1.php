<?php 
  include ("phpValidate.php");

  //SANITIZE Name
  if($_POST['name'] == "")
  {
    $errorMsg[] = "Name Cannot Be Blank";
  }
  else
  {
    $_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    if($_POST['name'] == "")
    {
      $errorMsg[] = "Name Cannot Be Blank";
    }
    elseif(!verifyAlphaNum($_POST['name']))
    {
      $errorMsg[] = "Name Contains Illigal Characters (letters, numbers, ?, !)";
    }
    elseif(strlen($_POST['name']) < 2)
    {
      $errorMsg[] = "Name Must Be Equal To Or Longer Than 2 Characters";
    }
  }

  //SANITIZE Email
  if($_POST['useremail'] == "")
  {
    $errorMsg[] = "Email Cannot Be Blank";
  }
  else
  {
    $_POST['useremail'] = filter_var($_POST['useremail'], FILTER_SANITIZE_EMAIL);
    if($_POST['useremail'] == "")
    {
      $errorMsg[] = "Email Cannot Be Blank";
    }
    elseif(!verifyEmail($_POST['useremail']))
    {
      $errorMsg[] = "Not a Valid Email Address";
    }
  }

  //SANITIZE message
  if($_POST['question'] == "")
  {
    $errorMsg[] = "Question Cannot Be Blank";
  }
  else
  {
    $_POST['question'] = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
    if($_POST['question'] == "")
    {
      $errorMsg[] = "Question Cannot Be Blank";
    }
    elseif(!verifyText($_POST['question']))
    {
      $errorMsg[] = "Question Contains Illigal Characters (letters, numbers, ?, !)";
    }
    elseif(strlen($_POST['question']) < 5)
    {
      $errorMsg[] = "Question Must Be Equal To Or Longer Than 5 Characters";
    }
  }

  if(!$errorMsg)
  {
    $sql = "SELECT fldContactEmail FROM tblGeneral";
    $temp = mysql_query($sql, $connectID);
    $row = mysql_fetch_array($temp);

    $to = $row[0];
    $subject = $_POST['name'];
    $message = "SENT VIA CAKED.COM";
    $message .= $_POST['question'];
    $headers = $_POST['useremail'];  
    $sent = mail($to, $subject, $message, $headers) ;
    if($sent)
    {
    	$succMsg[] = "Your Email Was Sent! We Will Respond Shortly!";
    }
    else
    {
    	$errorMsg[] = "Something Happened and Your Email Was Not Sent, Please Try Again";
    }
  }
 ?> 