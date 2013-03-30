<?php

  function verifyAlphaNum ($testString)
	{
      // Check for letters, numbers and dash, period, space and single quote only. 
      return (preg_match("/^([[:alnum:]]|-|\.| |')+$/", $testString));
  }    
  
  function verifyEmail ($testString)
	{
      // Check for a valid email address 
      return (preg_match("/^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$/", $testString));
  }
  
  function verifyText ($testString)
	{
      // Check for letters, numbers and dash, period, ?, !, space and single and double quotes only. 
      return (preg_match("/^([[:alnum:]]|-|\.| |\n|\r|\?|\!|\"|\')+$/",$testString));
  }
	
    function isDigits ($testString)
  {
    // CHECK FOR JUST NUMBERS!
    return ctype_digit($testString);
  }

	function isNumeric ($testString)
	{
		// CHECK FOR JUST NUMBERS!
  	return is_numeric($testString);
	}

?>