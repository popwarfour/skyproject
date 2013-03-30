<script type='text/javascript'>


   $(document).ready(function() {
   //settings
   var opacity = 0, toOpacity = 1, duration = 1;
   //set opacity ASAP and events
   $('subMenuItem').hover(function() {
      $(this).children('.subMenuItem').fadeTo(duration,toOpacity);
    }, function() {
      $(this).children('.subMenuItem').fadeTo(duration,opacity);
    }
  );
});
</script>
