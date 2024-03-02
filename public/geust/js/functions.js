// SCROLL TO TOP ===============================================================================
$(function() {
	$(window).scroll(function() {
		if($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();	
		} else {
			$('#toTop').fadeOut();
		}
	});
 
	$('#toTop').click(function() {
		$('body,html').animate({scrollTop:0},500);
	});	
	
});


// WIZARD  ===============================================================================


// OHTER ===============================================================================
 $(document).ready(function(){   
    
		//Menu mobile
		$(".btn-responsive-menu").click(function() {
			$("#top-nav").slideToggle(400);
		});
		
		//Check and radio input styles
		$('input.check_radio').iCheck({
    	checkboxClass: 'icheckbox_square-aero',
   	    radioClass: 'iradio_square-aero'
  		});
		
		//Pace holder
		$('input, textarea').placeholder();
				
		//Carousel
		$("#owl-demo").owlCarousel({
 
		items : 4,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3]
		 
		});
    
    });
/*===================================================================================*/
	/*  TWITTER FEED                                                                     */
	/*===================================================================================*/
	

		
		  	







    

