<script type='text/javascript'
	src='development-bundle/jquery-1.8.0.js'>
	</script>
	<script type='text/javascript'
	src='development-bundle/ui/jquery.ui.core.js'>
	</script>
	<script type='text/javascript'
	src='development-bundle/ui/jquery.ui.datepicker.js'>
	</script>
	<script type='text/javascript'
	src='development-bundle/ui/jquery.ui.widget.js'>
	</script>
<script>
	$(document).ready(function(){
    	$("#hideMe").click(function() {
	      $(this).slideUp(500);
	    });

    	$("#hideMe").slideDown(500);


    	$(function() {$(".datePicker").datepicker();
      		});
	});

	//scroll up
    $(document).ready(function(){

	    $(window).scroll(function(){
	        if ($(this).scrollTop() > 50) {
	            $('.scrollup').slideDown();
	        } else {
	            $('.scrollup').slideUp();
	        }
	    });

	    $('.scrollup').click(function(){
	        $("html, body").animate({ scrollTop: 0 }, 600);
	        return false;
	    });
 
    });
</script>