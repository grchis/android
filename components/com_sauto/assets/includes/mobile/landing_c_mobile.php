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

<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$img_path = JURI::base()."components/com_sauto/assets/images/";
$image_path = JURI::base()."components/com_sauto/assets";
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$last_visit = $user->lastvisitDate;
$query = "SELECT * FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$profil = $db->loadObject();
$width = 'style="width:800px;"';
//oferte castigate
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `is_winner` = '1'";
$db->setQuery($query);
$total_final_request = $db->loadResult();
//ofertele mele
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `is_winner` = '0'";
$db->setQuery($query);
$total_my_request = $db->loadResult();
//obtinere comentarii
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `proprietar` = '".$uid."' AND `data_adaugarii` > '".$last_visit."' AND `data_adaugarii` > '".$profil->data_1."' AND `raspuns` = '1' AND `readed_c` = '0'";
$db->setQuery($query);
$last_comms_n = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_comentarii WHERE `proprietar` = '".$uid."' AND `data_adaugarii` < '".$last_visit."' AND `data_adaugarii` > '".$profil->data_1."' AND `raspuns` = '1' AND `readed_c` = '0'";
$db->setQuery($query);
$last_comms = $db->loadResult();
//obtinere feedback
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."'";
$db->setQuery($query);
$all = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' AND `tip` = 'p'";
$db->setQuery($query);
$poz = $db->loadResult();
$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$uid."' AND `tip` = 'x'";
$db->setQuery($query);
$neg = $db->loadResult();
$neg2 = $poz + $neg;
	if ($poz != '') {
		if ($neg2 != '') {
			$feeds = $poz/$neg2;
		}
	}
															
				
//linkuri
$link_add = JRoute::_('index.php?option=com_sauto&view=add_request');
$link_final_request = JRoute::_('index.php?option=com_sauto&view=final_request');
$link_my_request = JRoute::_('index.php?option=com_sauto&view=my_request');
$link_comments = JRoute::_('index.php?option=com_sauto&view=comments');
$link_feedback = JRoute::_('index.php?option=com_sauto&view=feedback');	
?>
<div id="m_visitors" style="background-color:#F9F9F9" >
	<?php require_once('menu_filter.php');?>
	<div class = "main-container">
		<div class="user-options" style="width: 100%; height: auto; text-align: center;">
			<a href="/android/index.php?option=com_sauto&view=add_request" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_add_request.png" border="0">
				<br>
				Adauga cerere	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=search" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_search.png" border="0">
				<br>
				Cauta firme	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=my_request" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_my_request.png" border="0">
				<br>
				Cererile mele	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=final_request" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
				<img style="width: 30%; height: 30% !important;" src="./components/com_sauto/assets/images/icon_final_request.png" border="0">
				<br>
				Cereri finalizate	
			</a>
			<a href="/android/index.php?option=com_sauto&amp;view=edit_profile" class="sa_lk_profile" style="padding-top: 9%; width: 49%; height: 170px; display: inline-block; ">
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



