<style type="text/css">
p {
     margin: 0.5em 2% 0.5em;
}
form {
    margin: 0;
    padding-left: 2%;
    padding-right: 2%;
}
	  .pic-container{
	    margin-left:2%
	    float:left;
        width: 15%;
        display: inline-block;
    }
    .info-section{
		margin-right:2%;
         width: 80;
        display: inline-block;
    }
    @media screen and (max-width: 1210px){
	    .gkPage {
	        padding: 0 !important;
	    }
	}
</style>
<?php
defined('_JEXEC') || die('=;)');
$document = JFactory::getDocument();
require("toggle_js_mobile.php");
$document->addScriptDeclaration ($js_code);
$db = JFactory::getDbo();
$firma =& JRequest::getVar( 'firma', '', 'post', 'string' );
$domeniu =& JRequest::getVar( 'domeniu', '', 'post', 'string' );
$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );
$abonament =& JRequest::getVar( 'abonament', '', 'post', 'string' );
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$jid = $db->loadResult();
if ($judet == '') {
	$search_jud = '';
	$search_jud2 = '';
} else {
	$search_jud = " AND `judet` = '".$jid."'";
	$search_jud2 = " AND `p`.`judet` = '".$jid."'";
}
if ($city == '') {
	$search_city = '';
	$search_city2 = '';
} else {
	$search_city = " AND `localitate` = '".$city."'";
	$search_city2 = " AND `p`.`localitate` = '".$city."'";
}
$search_dom = " AND `categorii_activitate` LIKE '%".$domeniu."%' ";
$search_dom2 = " AND `p`.`categorii_activitate` LIKE '%".$domeniu."%' ";
if ($firma == '') {
	$search_firma = " `companie` != '' ";
} else {
	$search_firma = " `companie` LIKE '%".$firma."%' ";
}

if ($abonament == '') {
	$search_abonament = '';
	$search_abonament2 = '';
	$search_abonament3 = " AND `p`.`abonament` = `ab`.`id`";
} else {
	$search_abonament = " AND `abonament` = '".$abonament."'";
	$search_abonament2 = " AND `p`.`abonament` = '".$abonament."' AND `p`.`abonament` = `ab`.`id`";
	$search_abonament3 = "";
}
$query = "SELECT count(*) FROM #__sa_profiles WHERE ".$search_firma." ".$search_abonament." ".$search_jud." ".$search_dom." ".$search_city." ";
$db->setQuery($query);
$total = $db->loadResult();
$img_path = JURI::base()."components/com_sauto/assets/images/";
$image_path = JURI::base()."components/com_sauto/assets/users/";
$image = 'icon_profile.png';
$link_search = JRoute::_('index.php?option=com_sauto&view=searching');

if ($total == 0) {
	require_once('fara_anunturi.php');
}else{
	?>
<div id="m_visitors">
	<?php require_once('menu_filter.php');?>
		<?php
		$i=1;
			$query = "SELECT `p`.`uid`, `p`.`poza`, `p`.`companie`, `p`.`calificative`, `l`.`localitate`, `ab`.`abonament` FROM #__sa_profiles as `p` JOIN #__sa_localitati as `l` JOIN #__sa_abonament as `ab` ON `p`.`companie` LIKE '%".$firma."%' ".$search_abonament2." ".$search_jud2." AND `p`.`localitate` = `l`.`id` ".$search_abonament3." ".$search_dom2." ".$search_city2." ORDER BY `p`.`uid` DESC";
			$db->setQuery($query);
			$list = $db->loadObjectList();
			foreach ($list as $l) {
				$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->uid);
		?>
			<?php 
			if ($l->poza != '') {
					$poza = $image_path.$l->uid.DS.$l->poza;
				} else {
					$poza = $img_path.$image;
				}
			?>
		<div class="request-item">
			<div class="pic-container" data-id="<?php echo $l->companie ?>" data-category="categories">
					<img src="<?php echo $poza ?>" width="80" border="0" />
				</div>	
			<div class="info-section">
				<p>
					<a class="sa_public_profile" href="<?php echo $link_profile; ?>">
						<?php echo $l->companie;?><a class="sa_public_profile" href="<?php echo $link_profile;?>">
					</a>
				</p>
				<p>
					<?php echo JText::_('SAUTO_TIP_VANZATOR').': '.$l->abonament; ?>
				</p>
				<p>
					<?php echo JText::_('SAUTO_DISPLAY_CITY').': '.$l->localitate;
					?>
				</p>
				<p>
					<?php echo JText::_('SAUTO_CALIFICATIV_TITLE').': '.$l->calificative.'%'; ?>
				</p>				
			</div>
		</div>
		<?php
		} 
		?>	
		
<?php } ?>
</div>
<script type="text/javascript">
		var isMenuCollapsed = true;
		if (jQuery('#wrapper9 > h1')[0]) {
			jQuery('#wrapper9 > h1')[0].remove();
		}
		if (jQuery('#m_table')) {
			jQuery('#m_table').remove();
		}
		if (jQuery('#gkTopBar')) {
			jQuery('#gkTopBar').remove();
		}
		if (jQuery('#side_bar')) {
			jQuery('#side_bar').hide();
		}
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
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
