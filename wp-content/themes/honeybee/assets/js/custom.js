// Fullscreen Serach Box    
 ( function ($) {
  
    $(function() {      
      $('a[href="#searchbar_fullscreen"]').on("click", function(event) {    
    
        event.preventDefault();
        $("#searchbar_fullscreen").addClass("open");
        $('#searchbar_fullscreen > form > input[type="search"]').focus();
      });

      $("#searchbar_fullscreen, #searchbar_fullscreen button.close").on("click keyup", function(event) {
        if (
          event.target == this ||
          event.target.className == "close" ||
          event.keyCode == 27
        ) {
          $(this).removeClass("open");
        }
      });

    });    
		 
}) ( jQuery);