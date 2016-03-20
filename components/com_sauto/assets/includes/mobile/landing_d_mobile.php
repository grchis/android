<style type="text/css">
form {
    margin: 0;
    padding-left: 2%;
    padding-right: 2%;
}
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
<div id="m_visitors" style="background-color:#F9F9F9" >
	<?php require_once('menu_filter_d.php');?>

	<div class = "main-container">
		<div class="user-options" style="width: 100%; height: auto; text-align: center;">
			<a href="/android/index.php?view=requests" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_requests.png" border="0">
				<br>
				Cereri	
			</a>
			<a href="/android/index.php/component/sauto/?view=my_request" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_my_request.png" border="0">
				<br>
				Ofertele Mele
			</a>
			<a href="/android/index.php?view=final_request" class="sa_lk_profile" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_final_request.png" border="0">
				<br>
				Oferte Finalizate
			</a>
			<a href="/android/index.php?view=alerts" class="sa_lk_profile" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_alerts.png" border="0">
				<br>
				Alerte
			</a>
			<a href="/android/index.php/component/sauto/?view=edit_profile" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_edit_profile.png" border="0">
				<br>
				Editare profil	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=logout" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_logout.png" border="0">
				<br>
				Inchide aplicatia	
			</a>
		</div>
	</div>
</div>

<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')

		if (jQuery('#m_table')) {
			jQuery('#m_table').remove();
		}
		if (jQuery('#gkTopBar')) {
			jQuery('#gkTopBar').remove();
		}
		if (jQuery('#sa_reclame_top')) {
			jQuery('#sa_reclame_top').remove();
		}
		if (jQuery('#sa_viz_side_bar')) {
			jQuery('#sa_viz_side_bar').remove();
		}
		if (jQuery('#additional_content')) {
			jQuery('#additional_content').remove();
		}

		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
		jQuery('#menu-icon').on('click', toggleMenu);

		jQuery('.menu-option-text').on('click', redirectToMenuOption);
</script>

