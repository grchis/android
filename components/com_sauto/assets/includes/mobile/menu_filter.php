	<div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
		<img id="menu-icon" class="menu-button" src="./components/com_sauto/assets/images/menu-icon.png" />
	</div>

	<div id="main-menu" style="display: none;">
        <div class="menu-option" data-href="/android/index.php?option=com_sauto&view=add_request">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_requests.png" border="0">
          <span class="menu-option-text"> Adauga cerere </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=search">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_my_request.png" border="0">
          <span class="menu-option-text"> Cauta firme </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?view=final_request">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_final_request.png" border="0">
          <span class="menu-option-text"> Cererile mele </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=final_request">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_alerts.png" border="0">
          <span class="menu-option-text"> Cereri finalizate </span>
        </div>

        <div class="menu-option" data-href="/android/index.php/component/sauto/?view=edit_profile">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_edit_profile.png" border="0">
          <span class="menu-option-text"> Editare profil </span>
        </div>

        <div class="menu-option" data-href="/android/index.php?option=com_sauto&amp;view=logout">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_logout.png" border="0">
          <span class="menu-option-text"> Inchide Aplicatia </span>
        </div>
    </div>
<script type="text/javascript">
		var isMenuCollapsed = true;
		if (jQuery('#m_table')) {
			jQuery('#m_table').remove();
		}
		if (jQuery('#gkTopBar')) {
			jQuery('#gkTopBar').remove();
		}
		if (jQuery('#side_bar')) {
			jQuery('#side_bar').remove();
		}
		if (jQuery('#sa_viz_side_bar')) {
			jQuery('#sa_viz_side_bar').remove();
		}
		if (jQuery('#additional_content')) {
			jQuery('#additional_content').remove();
		}
		document.getElementsByTagName('h1')[0].remove();
		
		jQuery('#menu-icon').on('click', toggleMenu);

		jQuery('.menu-option-text').on('click', redirectToMenuOption);


		function toggleMenu () {
	   if (isMenuCollapsed){
	        isMenuCollapsed = false;
	        jQuery('#main-menu').show(500);
	    }
	    else{
	        isMenuCollapsed = true;
	        jQuery('#main-menu').hide(500);
	    }
		}

	function redirectToMenuOption (event) {
  		event.preventDefault();
  		event.stopPropagation();

  		window.location.href = jQuery(event).data('href');
	}
	
</script>