<?php
$jspopup = "jQuery(document).ready(function() {	
	
			var id = '#dialog';
		
			//Get the screen height and width
			var maskHeight = jQuery(document).height();
			var maskWidth = jQuery(window).width();
		
			//Set heigth and width to mask to fill up the whole screen
			jQuery('#mask').css({'width':maskWidth,'height':maskHeight});
			
			//transition effect		
			jQuery('#mask').fadeIn(800);	
			jQuery('#mask').fadeTo(\"slow\",0.8);	
		
			//Get the window height and width
			var winH = jQuery(window).height();
			var winW = jQuery(window).width();
				  
			//Set the popup window to center
			jQuery(id).css('top',  winH/2-jQuery(id).height()/2 -50);
			jQuery(id).css('left', winW/2-jQuery(id).width()/2);
		
			//transition effect
			jQuery(id).fadeIn(500); 	
		
		//if close button is clicked
		jQuery('.window .close').click(function (e) {
			//Cancel the link behavior
			e.preventDefault();
			
			jQuery('#mask').hide();
			jQuery('.window').hide();
		});		
		
		//if mask is clicked
		jQuery('#mask').click(function () {
			jQuery(this).preventDefault();
			jQuery(this).hide();
			jQuery('.window').hide();
		});		
		
	});";
	
$jspopup2 = "
    function showMe (box, act) {        
        var chboxs = document.getElementsByName(act);
        var vis = \"none\";
        for(var i=0;i<chboxs.length;i++) { 
            if(chboxs[i].checked){
             vis = \"block\";
                break;
            }
        }
        document.getElementById(box).style.display = vis;  
    }
";

$jspopup3 = "
jQuery(window).load(function(){
jQuery(document).ready(function (jQuery) {
 
    jQuery('[data-popup-target]').click(function () {
        jQuery('html').addClass('overlay');
        var activePopup = jQuery(this).attr('data-popup-target');
        jQuery(activePopup).addClass('visible');
 
    });
 
    jQuery(document).keyup(function (e) {
        if (e.keyCode == 27 && jQuery('html').hasClass('overlay')) {
            clearPopup();
        }
    });
 
    jQuery('.popup-exit').click(function () {
        clearPopup();
 
    });
 
    jQuery('.popup-overlay').click(function () {
        clearPopup();
    });
 
    function clearPopup() {
        jQuery('.popup.visible').addClass('transitioning').removeClass('visible');
        jQuery('html').removeClass('overlay');
 
        setTimeout(function () {
            jQuery('.popup').removeClass('transitioning');
        }, 200);
    }
 
});
});
";
	?>
