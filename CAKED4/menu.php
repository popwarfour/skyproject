<div id='menuDiv'>
		<a href="index.php" class="menuButton home" style="margin: 0px; width: 90px;">Home</a>
		<a href="contest.php" class="menuButton trophy" style="margin:0px; width: 90px;">Contest</a>
		<a href="shop.php" class="menuButton tshirt" style="margin:0px; width: 90px;">Shop</a>
		<a href="about.php" class="menuButton about" style="margin:0px; width: 90px;">About</a>
		<a href="contact.php" class="menuButton contact" style="margin:0px; width: 90px;">Contact</a>
		<?php
		    	if(!$_SESSION['loggedIn'])
		    	{
		    		echo "<a href='signup.php' class='menuButton members' style='margin:0px; width: 90px;'>Sign Up</a>";
		    	}
		    	elseif($_SESSION['adminLevel'] > 1)
		    	{
		    		echo "<a href='managers.php' class='menuButton settings' style='margin:0px; width: 90px;'>Settings</a>";	
		    	}
	    	?>
	    </ul>
		<div style="clear: both;"></div>
	</div>
	<!-- 	<div id='menuDiv'>
    	<ul id="subMenuUL">tshirt
			<a class='noEffects' href='index.php'><li class='subMenuItem'>Home</li></a>
		    <a class='noEffects' href='contest.php'><li class='subMenuItem'>Contest</li></a>
		    <a class='noEffects' href='shop.php'><li class='subMenuItem'><p style='padding: 0px; margin: 0px;'>Shop<span style='margin: 0px; padding: 0px; font-size: 8px; color: red;'>COMING SOON</span></p></li></a>
		    <a class='noEffects' href='about.php'><li class='subMenuItem'>About</li></a>
		    <a class='noEffects' href='contact.php'><li class='subMenuItem'>Contact</li></a>
		    <?php
		    /*
		    	if(!$_SESSION['loggedIn'])
		    	{
		    		echo "<a class='noEffects' href='signup.php'><li class='subMenuItem'>Sign Up</li></a>";
		    	}
		    	elseif($_SESSION['adminLevel'] > 1)
		    	{
		    		echo "<a class='noEffects' href='managers.php'><li class='subMenuItem'>Managers</li></a>";	
		    	}
		    	*/
	    	?>
	    </ul>
		<div style="clear: both;"></div>
	</div> -->