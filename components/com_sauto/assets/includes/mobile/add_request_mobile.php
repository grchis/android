<?php
defined('_JEXEC') || die('=;)');
$db = JFactory::getDbo();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//get article
$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->login_article."'";
$db->setQuery($query);
$login_article = $db->loadResult();


$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->request_article."'";
$db->setQuery($query);
$request_article = $db->loadResult();
$link_form = JRoute::_('index.php?option=com_sauto&view=add_request2');
$img_path = JURI::base()."components/com_sauto/assets/images/forms/";
?>
<div id="m_visitors" style="background-color:#F9F9F9">
<?php 
require_once('menu_filter.php');
?>
	<h3> Adauga Cerere Noua </h3>
	<div class = "main-container">
	<form action="<?php echo $link_form;?>" method="POST">
		<select name="request" onchange="this.form.submit()" class="sa_select_mic">
			<option value="0" selected="">Alege tipul cererii</option>
			<option value="1">Piese auto</option>
			<option value="2">Inchirieri</option>
			<option value="3">Auto noi</option>
			<option value="4">Auto rulate</option>
			<option value="5">Tractari auto</option>
			<option value="7">Accesorii auto</option>
			<option value="1">Service auto</option>
			<option value="9">Tuning</option>	
		</select>
	</form>
	</div>
</div>
<script type="text/javascript">
	window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>');
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

</script>

<style type="text/css">
	@media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
