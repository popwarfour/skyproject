<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Anders D Melen" />
	<meta name="description" content="Vermonts fines maples syrup" />
	<META NAME="Title" CONTENT="Twin Maple Sugarworks Vermont - Home">
	<meta name="keywords" content="" />
	<link rel="stylesheet" href="mystyle.css" type="text/css" media="screen" />	
	<link rel="stylesheet" href="button.css" type="text/css" media="screen" />
	<link rel='stylesheet' href='development-bundle/themes/base/jquery.ui.all.css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
	<script src="cycle.js" ></script>
	<script type="text/javascript">
		$('#fade').cycle();
		$('#slide').cycle(
		{ 
		    fx:      'turnRight', 
		    delay:   -4000 
		});
	</script>
</head>
<body>
	<div  class='mainContainer'>
		<div class='banner'>
			<img src='images/digitalLogo.png' id='bannerImage' />
			<p id='bannerText'>Twin Maple Sugarworks</p>
			<p id='bannerSubtext'>Vermonts Finest Maple Syrup</p>
		</div>
		<div class='menuContainer'>
			<a href='index.php'><div class='menuLink-Left'>Home</div></a>
			<a href='about.php'><div class='menuLink-Middle'>About</div></a>
			<a href='purchase.php'><div class='menuLink-Middle-Selected'>Purchase</div></a>
			<a href='contact.php'><div class='menuLink-Right'>Contact</div></a>
			<div style="clear: both;"></div>
		</div>
		<div class='contentPane'>
			<div  id='slide' style='float:left;'>
				<img class='contentImages' src='images/sugaring.jpg'/>
				<img class='contentImages' src='images/lincoln.jpg' />
				<img class='contentImages' src='images/vermont.jpg' />
				<img class='contentImages' src='images/forest.jpg' />
				<img class='contentImages' src='images/sugaringInFullEffect.jpg'/>
			</div>
			<div style='float: left;' class='contentPaneRight'>
				<h2 style='padding: 0px; margin: 0px;'>Maple Syrup - Order Online!</h2>
				<table border='0px' style='padding: 0px; margin: 0px;'>
					<tr>
						<td class='contentPaneRight-SyrupSize'>
							<img style='margin-top: 50px;' src='images/sizes/syrup.png' width='19px' alt='half pint'/>
							</br>
							&#189; Pint
						</td>
						<td class='contentPaneRight-SyrupSize'>
							<img style='margin-top: 40px;' src='images/sizes/syrup.png' width='29px' alt='half pint'/>
							</br>
							Pint
						</td>
						<td class='contentPaneRight-SyrupSize'>
							<img style='margin-top: 30px;' src='images/sizes/syrup.png' width='39px' alt='half pint'/>
							</br>
							16oz
						</td>
						<td class='contentPaneRight-SyrupSize'>
							<img style='margin-top: 10px;' src='images/sizes/syrup.png' width='49px' alt='half pint'/>
							</br>
							&#189; Gallon
						</td>
						<td class='contentPaneRight-SyrupSize'>
							<img src='images/sizes/syrup.png' alt='half pint'/>
							</br>
							Gallon
						</td>
					</tr>
				</table>
				<h2 style='padding: 0px;  margin: 0px;'>Education</h3>
				<p style='padding: 0px;  margin: 0px;'>
					<a href='http://vermontmaple.org/'>Vermont Maple Sugar Association</a></br>
					<a href='http://www.huffingtonpost.com/2011/12/23/maple-syrup-grades_n_1167767.html#s570988&title=Grade_A_Dark'>Syrup Grading System</a>
				</p>
			</div>
		</div>
		<div class='smallBanner'>
			<p class='smallBannerTitle'>Latest From the Sugarbush</p>
		</div>
		<div class='footer'>
			Footer
		</div>
	</div>
</body>