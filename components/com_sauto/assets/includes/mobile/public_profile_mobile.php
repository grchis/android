<style type="text/css">
	h1{
		display:none;
	}
    p{
        margin: 0;
    }
    .pic-container{
        width: 15%;
        display: inline-block;
    }
    .info-section{
         width: 45%;
        display: inline-block;
    }
    .contact-section{
        width: 33%;
        display: inline-block;
        vertical-align: top;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
#gkMainbody table:before {
    content: "";
  }
</style>
<?php
defined('_JEXEC') || die('=;)');
//obtin id
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
//echo '>>>> user id > '.$id;
$user =& JFactory::getUser();
$uid = $user->id;

$img_path = JURI::base()."components/com_sauto/assets/images/";
$image_path = JURI::base()."components/com_sauto/assets";
$db = JFactory::getDbo();
//obtinem tipul de utilizator
$query = "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$id."'";
$db->setQuery($query);
$tip_cont = $db->loadResult();
if ($tip_cont == 0) {
	$query = "SELECT `p`.`poza`, `p`.`fullname`,  `p`.`adresa`, `p`.`telefon`, `p`.`uid`, `j`.`judet`, `u`.`registerDate`, `l`.`localitate` FROM #__sa_profiles as `p` JOIN #__sa_judete as`j` JOIN #__users as `u` JOIN #__sa_localitati as `l` ON `p`.`uid` = '".$id."' AND `p`.`uid` = `u`.`id` AND `p`.`judet` = `j`.`id` AND `p`.`localitate` = `l`.`id`";
} else {
	$query = "SELECT `p`.`poza`, `p`.`companie`, `p`.`reprezentant`, `p`.`sediu`, `p`.`telefon`, `p`.`uid`, `j`.`judet`, `u`.`registerDate`, `l`.`localitate` FROM #__sa_profiles as `p` JOIN #__sa_judete as`j` JOIN #__users as `u` JOIN #__sa_localitati as `l` ON `p`.`uid` = '".$id."' AND `p`.`uid` = `u`.`id` AND `p`.`judet` = `j`.`id` AND `p`.`localitate` = `l`.`id`";
} 
//$query = "SELECT `p`.*, `j`.`judet`, `u`.`registerDate` FROM #__sa_profiles as `p` LEFT JOIN #__sa_judete as`j` ON `p`.`judet` = `j`.`id` AND `p`.`uid` = '".$id."' JOIN #__users as `u` ON `u`.`id` = `p`.`uid`";
$db->setQuery($query);
$profil = $db->loadObject();

//verificam nivelul de acces
$query = "SELECT `tip_cont`, `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$types = $db->loadObject();
$view_phone = 0;
if ($types->tip_cont == 1) {
	//verificam abonamentul
	if ($types->abonament == 3) {
		$view_phone = 1;
	}
}
?>
<div id="m_visitors">
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
	<p><span> Reprezentant: </span> <?php
				if ($tip_cont == 0) {
					echo $profil->fullname; 
				} else {
					echo $profil->companie;	
				}?></p>
	<p><span> Oras: </span>	 <?php  echo $profil->localitate; ?></p>
	<p><span> Judet: </span>    <?php  echo $profil->judet; ?></p>
	<p><span> Adresa: </span>   <?php echo $profil->adresa; ?></p>
	<p><span> Data Inregistrare: </span><?php 	$data_inreg = explode(" ", $profil->registerDate);echo $data_inreg[0]; ?></p>
	<p><span> Calificativ: </span> <?php  echo round(100*$feeds,2).'% ('.$all.')';?></p>
	<table class="sa_table_class">
					<tr class="sa_table_feedback_row">
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_TYPE'); ?></th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_LAST_MONTH'); ?></th>
						<th class="sa_table_feedback_cell">6 luni</th>
						<th class="sa_table_feedback_cell"><?php echo JText::_('SAUTO_FEEDBACK_TOTAL'); ?></th>
					</tr>
					<?php
					//obtin calificativele
					$curent_date = time();
					$last_30 = $curent_date - 2592000;
					$last_6 = $curent_date - 15552000;
					//echo '>>> '.$curent_date.'<br />';
					$last_30 = date("Y-m-d h:i:s", $last_30);
					$last_6 = date("Y-m-d h:i:s", $last_6);
					//echo '>>>> '.$last_30.'<br />';
					//echo '>>>>> '.$last_6.'<br />';
					//pozitiv series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$poz_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$poz_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'p'";
					$db->setQuery($query);
					$poz_3 = $db->loadResult();
					//negativ series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$neg_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$neg_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'x'";
					$db->setQuery($query);
					$neg_3 = $db->loadResult();
					//neutru series
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n' AND `data_cal` > '".$last_30."'";
					$db->setQuery($query);
					$neu_1 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n' AND `data_cal` > '".$last_6."'";
					$db->setQuery($query);
					$neu_2 = $db->loadResult();
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `dest_id` = '".$id."' AND `tip` = 'n'";
					$db->setQuery($query);
					$neu_3 = $db->loadResult();
					//echo '???? '.$poz_1.' >>> '.$poz_2.' ???? '.$poz_3;
					?>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_pozitiv.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_POZITIV'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $poz_3; ?></td>
					</tr>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_neutru.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_NEUTRU'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neu_3; ?></td>
					</tr>
					<tr class="sa_table_feedback_row">
						<td class="sa_table_dfeedback_cell">
							<img src="<?php echo $img_path; ?>feedback_negativ.png" border="0" />
							<span class="sa_feed_label"><?php echo JText::_('SA_FEEDBACK_NEGATIV'); ?></span>
						</td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_1; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_2; ?></td>
						<td class="sa_table_dfeedback_cell"><?php echo $neg_3; ?></td>
					</tr>
				</table>
</div>


<script type="text/javascript">
		var isMenuCollapsed = true;
		jQuery('#menu-icon').on('click', toggleMenu);
		jQuery('.menu-option-text').on('click', redirectToMenuOption);
		document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100%;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}#gkMainbody table{ width: 100% !important; }' + 
						'#gkMainbody table tbody, #gkMainbody table thead, #gkMainbody table tfoot{ width: 100% !important; }' + 
						'span{ display: inline-block; width: 45%; } p{ margin-top: 2px; margin-bottom: 2px;}</style>'
		);
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