<?php
	// ------------------- LOGIN DIV --------------------------
	if(!$_SESSION['loggedIn'])
	{
		echo "<div id='loginDiv'>";
			echo "<span style='float: right;'>";
			echo "<form style='display: block; float: left;' action='" . $_SERVER['PHP_SELF'] . "' method='post' class='noMargin'>
			<input type='text' size='10' name='username' id='username' value='username'/>
			<input type='password' size='10' name='password' id='password' value='password'/>
			<input type='submit' value='Login' class='button' style='margin: 0px; padding: 0px; padding-left: 5px; padding-right: 5px;' name='submitLogin' id='submitLogin'/>
			</form>
			<form style='display: block; float: right;' action='signup.php' method='post' class='noMargin'>
			<input type='submit' value='?' class='button'  style='margin: 0px; padding: 0px; padding-left: 5px; padding-right: 5px;' name='submitResetPassword' id='submitResetPassword'/>
			</form>";
		echo "</span>";
		echo "</div>";
	}
	else
	{
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
	        echo "<div style='clear: both;'></div>";
	    echo "</div>";
	}
?>