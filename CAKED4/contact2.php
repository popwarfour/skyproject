<?php
  include ("phpValidate.php");

  //SANITIZE Name
  if($_POST['pName'] == "")
  {
    $errorMsg[] = "Name Cannot Be Blank";
  }
  else
  {
    $_POST['pName'] = filter_var($_POST['pName'], FILTER_SANITIZE_STRING);
    if($_POST['pName'] == "")
    {
      $errorMsg[] = "Name Cannot Be Blank";
    }
    elseif(!verifyAlphaNum($_POST['pName']))
    {
      $errorMsg[] = "Name Contains Illigal Characters (letters, numbers, ?, !)";
    }
    elseif(strlen($_POST['pName']) < 2)
    {
      $errorMsg[] = "Name Must Be Equal To Or Longer Than 2 Characters";
    }
  }

  //SANITIZE phone
  if($_POST['userphone'] == "")
  {
    $errorMsg[] = "Phone Number Cannot Be Blank";
  }
  else
  {
    $_POST['userphone'] = filter_var($_POST['userphone'], FILTER_SANITIZE_STRING);
    if($_POST['userphone'] == "")
    {
      $errorMsg[] = "Phone Number Cannot Be Blank";
    }
    elseif(!isNumeric($_POST['userphone']))
    {
      $errorMsg[] = "Phone Number Contains Illigal Characters (letters)";
    }
    elseif(strlen($_POST['userphone']) != 10)
    {
      $errorMsg[] = "Phone Number Must Be 10 Digits (FORMAT: XXXXXXXXXX";
    }
  }

  //SANITIZE message
  if($_POST['pQuestion'] == "")
  {
    $errorMsg[] = "Question Cannot Be Blank";
  }
  else
  {
    $_POST['pQuestion'] = filter_var($_POST['pQuestion'], FILTER_SANITIZE_STRING);
    if($_POST['pQuestion'] == "")
    {
      $errorMsg[] = "Question Cannot Be Blank";
    }
    elseif(!verifyText($_POST['pQuestion']))
    {
      $errorMsg[] = "Question Contains Illigal Characters (letters, numbers, ?, !)";
    }
    elseif(strlen($_POST['pQuestion']) > 255)
    {
      $errorMsg[] = "Question Cannot Be Longer Than 255 Characters";
    }
  }

  if(!$errorMsg)
  {
    $sql = "SELECT fldContactPhone FROM tblGeneral";
    $temp = mysql_query($sql, $connectID);
    $row = mysql_fetch_array($temp);

    $to = $row[0] . "@vtext.com";
    $subject = $_POST['pName'];
    $message = $_POST['pQuestion'];
    $headers = "|SENT VIA CAKED.COM| By: ";
    $headers .= $_POST['userphone'];

    $sent = mail($to, $subject, $message, $headers) ;
    if($sent)
    {
      $succMsg[] = "Your Text Message Was Sent! We Will Respond Shortly!";
    }
    else
    {
      $errorMsg[] = "Something Happened and Your Text Message Was Not Sent, Please Try Again";
    }
  }
?> 
