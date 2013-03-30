<!doctype html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title></title>
		<meta name="description" content="">

		<!-- Mobile viewport optimized: h5bp.com/viewport -->
		<meta name="viewport" content="width=device-width">
		
		<!-- JavaScript at the bottom for fast page loading -->
		<script type="text/javascript"
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js">
	</script>
	</head>

	<body>
	  
	  <div id="hideMe" style="background-color:gray;">click me</div>
	  <div id="stuff" style="background-color:green;">to remove me</div>
	  	<script>
	  	$("#hideMe").click(function() 
	  	{
		  //alert("Handler for .click() called.");
		  $("#stuff").hide();
		});
		</script>
	  </div><!-- end hideme-->

		


	</body>
</html>