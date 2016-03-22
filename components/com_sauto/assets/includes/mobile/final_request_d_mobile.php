
<style type="text/css">
    p{
        margin: 0;
    }
    .pic-container{
        width: 15%;
        display: inline-block;
    }
    .info-section{
         width: 39%;
        display: inline-block;
    }
    .contact-section{
        width: 39%;
        display: inline-block;
        vertical-align: top;
    }
	.action-button{
		text-align: center;
		width: 30%;
		max-width: 100px;
		display: inline-block;
		background-color: #509EFF;
		font-size: 20px;
		color: white;
		padding-top: 4px;
		padding-bottom: 4px;
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

$link_this = JRoute::_('index.php?option=com_sauto&view=final_request');
$link_filter = JRoute::_('index.php?option=com_sauto&view=requests_f&task=final');
$db_piese = "";
$app =& JFactory::getApplication();

$piese =& JRequest::getVar( 'piese', '', 'post', 'string' );
$judete =& JRequest::getVar( 'judete', '', 'post', 'string' );
$marci =& JRequest::getVar( 'marci', '', 'post', 'string' );
$modele =& JRequest::getVar( 'modele', '', 'post', 'string' );
$orase =& JRequest::getVar( 'orase', '', 'post', 'string' );

if ($piese != '') {
	$app->setUserState('piese', $piese);
}
if ($judete != '') {
	$app->setUserState('judete', $judete);
}
if ($marci != '') {
	$app->setUserState('marci', $marci);
}

if ($modele != '') {
	$app->setUserState('modele', $modele);
}
if ($orase != '') {
	$app->setUserState('orase', $orase);
}

$ck_piese = $app->getUserState('piese');
if ($ck_piese == 0) {
	$db_piese .= "";
} elseif ($ck_piese == 1) {
	//obtin tipul piesei
	$tip_piesa =& JRequest::getVar( 'tip_piesa', '', 'post', 'string' );
		if ($tip_piesa == 1) {
			$db_piese_noi = " AND `nou` = '1'";
			$db_piese_sh = "";
		} elseif ($tip_piesa == 2) {
			$db_piese_sh = " AND `sh` = '1'";
			$db_piese_noi = "";
		} else {
			$db_piese_sh = "";
			$db_piese_noi = "";
		}
	$db_piese .= " AND `tip_anunt` = '1'".$db_piese_noi.$db_piese_sh;
} elseif ($ck_piese == '2') {
	$db_piese .= " AND `tip_anunt` = '2'";
} elseif ($ck_piese == '3') {
	$db_piese .= " AND `tip_anunt` = '3'";
} elseif ($ck_piese == '4') {
	$pret_maxim =& JRequest::getVar( 'pret_maxim', '', 'post', 'string' );
	$s_moneda =& JRequest::getVar( 's_moneda', '', 'post', 'string' );
	//echo '>>> '.$pret_maxim.' >>>'. $s_moneda;
	if ($pret_maxim != '') {
		$db_pret_maxim = " AND `buget_max` >= '".$pret_maxim."' AND `buget_moneda` = '".$s_moneda."'";
	} else {
		$db_pret_maxim = '';
	}
	$db_piese .= " AND `tip_anunt` = '4'".$db_pret_maxim;
} elseif ($ck_piese == '5') {
	$db_piese .= " AND `tip_anunt` = '5'";
} elseif ($ck_piese == '8') {
	$db_piese .= " AND `tip_anunt` = '8'";
} elseif ($ck_piese == '9') {
	$db_piese .= " AND `tip_anunt` = '9'";
}

$ck_judete = $app->getUserState('judete');
if ($ck_judete == 0) {
	$db_judete = "";
} else {
	$db_judete = " AND `judet` = '".$ck_judete."'";
}
$ck_marci = $app->getUserState('marci');
//echo 'chk marci >>>> '.$ck_marci.'<br />';
if ($ck_marci == 0) {
	$db_marci = "";
} else {
	$db_marci = " AND `marca_auto` = '".$ck_marci."'";
}
$ck_modele = $app->getUserState('modele');
if ($ck_modele == 0) {
	$db_modele = "";
} else {
	$db_modele = " AND `model_auto` = '".$ck_modele."'";
}
$ck_orase = $app->getUserState('orase');
if ($ck_orase == 0) {
	$db_orase = "";
} else {
	$db_orase = " AND `city` = '".$ck_orase."'";
}


$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT * FROM #__sa_raspunsuri AS `r` 
		JOIN #__sa_anunturi as `a` 
		ON `r`.`firma` = '".$uid."' 
		AND `r`.`anunt_id` = `a`.`id` 
		AND `a`.`uid_winner` = '".$uid."' 
		 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
		 GROUP BY `r`.`anunt_id` ";
$db->setQuery($query);
$db->execute();
$total = $db->getNumRows();
if ($total == 0) {
	//nu ai anunturi
require_once('fara_anunturi.php');
} else {
$link = JRoute::_('index.php?option=com_sauto&view=final_request');
$query = "SELECT * FROM #__sa_raspunsuri AS `r` 
		JOIN #__sa_anunturi as `a` 
		ON `r`.`firma` = '".$uid."' 
		AND `r`.`anunt_id` = `a`.`id` 
		AND `a`.`uid_winner` = '".$uid."' 
		 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
		 GROUP BY `r`.`anunt_id` ORDER BY `a`.`data_castigare` DESC ";
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = JURI::base()."components/com_sauto/assets/users/";
require("calificativ_mobile.php");

?>
<!---==========================MOBILE==========================================================================================================================================================================--->
<div id="m_visitors" style="width:100%!important;background-color:#F9F9F9">
<div class = "m_header" style="width: 100%; height: 100px; background-color: #509EFF">
		<img id="menu-icon" class="menu-button" src="./components/com_sauto/assets/images/menu-icon.png" />
		<img id="filter-button" class="menu-button" style="right: 80px;"src="<?php echo $img_path?>filter-icon.png" />
	</div>

	<div id="main-menu" style="display: none;">
        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_requests.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?view=add_request"> Adauga cerere </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_my_request.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?view=search"> Cauta firme </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_final_request.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?view=my_request"> Cererile mele </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_alerts.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?view=final_request"> Cereri finalizate </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_edit_profile.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php/component/sauto/?view=edit_profile"> Editare profil </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_logout.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?view=logout"> Inchide Aplicatia </span>
        </div>
	</div>
 <div id="filter-menu" style="display: none;">
        <p class="filter-category-name">Oferte</p>
        <ul class="filter-category">
            <li class="category-item" data-category="oferte" data-id="2"> Toate Cererile </li>
            <li class="category-item" data-category="oferte" data-id="1"> Cu oferte </li>
            <li class="category-item" data-category="oferte" data-id="0"> Fara Oferte</li>
        </ul>

        <p class="filter-category-name">Judet</p>
        <ul class="filter-category">
		<li class="category-item" data-category="judete" data-id="0">Toate Judetele</li>
            <?php
            $query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
            $db->setQuery($query);
            $regions = $db->loadObjectList();
            foreach ($regions as $rg) { ?>
                <li class="category-item" data-category="judete" data-id="<?php echo $rg->id ?>"><?php echo $rg->judet ?></li>
            <?php }
            ?>
        </ul>

        <p class="filter-category-name">Marca</p>
        <ul class="filter-category">
		  <li class="category-item" data-category="marci" data-id="0">Toate Marcile</li>
            <?php
            $query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
            $db->setQuery($query);
            $marci = $db->loadObjectList();
            foreach ($marci as $mc) {?>
                <li class="category-item" data-category="marci" data-id="<?php echo $mc->id ?>"><?php echo $mc->marca_auto ?></li>
            <?php }
            ?>
        </ul>
    </div>
	<!--=====================================MOBILLLLEE CONTENT======================================================-->
<div id="main-container" style="width:100%!important">
	<?php
	$i=1;
	foreach ($list as $l) {
	$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
	$image = 'anunt_type_'.$l->tip_anunt.'.png';
	?>
		<?php //verificare poze
			$query = "SELECT `poza`,`alt` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."'";
			$db->setQuery($query);
			$pics = $db->loadObject();
			if ($pics->poza != '') {
				$poza = $image_path.$l->proprietar."/".$pics->poza;
				$alt = $pics->alt;
			} else {
				$poza = $img_path.$image;
				$alt = '';
			}
		?>
<div class="request-item">
				<a href="<?php echo $link_categ; ?>" class="sa_lk_profile">
					<div class="pic-container" data-id="<?php echo $l->tip_anunt ?>" data-category="categories">
						<p><?php echo JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt) ?> </p>
						<img src="<?php echo $poza ?>" width="80" border="0" />
					</div>
				</a>
                <div class="info-section">
                    <p><strong>
                        <a href="<?php
										$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
										echo $link_anunt;
										?>">
										<?php echo $l->titlu_anunt; ?>
						</a>
					</strong></p>
                    <p> <?php echo strip_tags($l->anunt) ?></p>
	
                    <?php if ($l->marca_auto != 0) {
                        //obtin marca si modelul
                        $query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
                        $db->setQuery($query);
                        $marca = $db->loadResult();
                    }?>
                       <?php if ($l->model_auto != 0) {
                        $query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
                        $db->setQuery($query);
                        $model = $db->loadResult();
                    } ?>
                    <p> <?php echo $marca.': '.$model; ?> </p>
					<p> 
						<?php
						//obtin pret + moneda
						$query = "SELECT `r`.`pret_oferit`, `m`.`m_scurt` FROM #__sa_raspunsuri as `r` JOIN #__sa_moneda as `m` ON `r`.`anunt_id` = '".$l->id."' AND `r`.`status_raspuns` = '1' AND `r`.`moneda` = `m`.`id`";
						$db->setQuery($query);
						$curency = $db->loadObject();
						echo JText::_('SAUTO_DISPLAY_PRICE').'<br />'.$curency->pret_oferit.' '.$curency->m_scurt;
						?>
					</p>
	                </div>
                <div class="contact-section">
					<?php
						$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
						$db->setQuery($query);
						$acordate = $db->loadResult();
						if ($acordate == 1) {
							//calificativ acordat
							$query = "SELECT `tip`, `mesaj` FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
							$db->setQuery($query);
							$calif = $db->loadObject();
							echo'<p>'.$calif->mesaj.'</p>';
							echo '<div style="display:inline;">';
							if ($calif->tip == 'p') { $calif_p = 'feedback_pozitiv.png'; } else { $calif_p = 'feedback_pozitiv_gri.png'; }
							echo '<img src="'.$img_path.$calif_p.'" />';
							if ($calif->tip == 'n') { $calif_n = 'feedback_neutru.png'; } else { $calif_n = 'feedback_neutru_gri.png'; 	}
							echo '<img style="margin-left: 6%;" src="'.$img_path.$calif_n.'" />';
							if ($calif->tip == 'x') { $calif_x = 'feedback_negativ.png'; } else { $calif_x = 'feedback_negativ_gri.png'; }
							echo '<img style="margin-left: 6%;" src="'.$img_path.$calif_x.'" />';
						} else {
						$link_calificativ = JRoute::_('index.php?option=com_sauto&view=calificativ');
						?>
							<form action="<?php echo $link_calificativ; ?>" method="post" name="calificativ_<?php echo $l->id; ?>" id="calificativ_<?php echo $l->id; ?>">
								<textarea name="calificativ_mess" cols="15" rows="1"></textarea>
								<div>
								<?php
								$calif_p = 'feedback_pozitiv_gri.png';	
								$calif_n = 'feedback_neutru_gri.png';							
								$calif_x = 'feedback_negativ_gri.png';
						 ?>
								<div id="calificativ_value_<?php echo $l->id; ?>" >
									<div style="width: 40px; display:inline-block;">
										<label for="pozitiv_<?php echo $l->id; ?>">
											<input type="radio" name="calificativ_value" id="pozitiv_<?php echo $l->id; ?>" value="p" />
											<img src="<?php echo $img_path.$calif_p; ?>" alt="Pozitiv" />
										</label>
									</div>
								
									<div style="width: 40px; margin-left:4%; display:inline-block;">
										<label for="neutru_<?php echo $l->id; ?>">
											<input type="radio" name="calificativ_value" id="neutru_<?php echo $l->id; ?>" value="n" />
											<img src="<?php echo $img_path.$calif_n; ?>" alt="Neutru" />
										</label>
									</div>
								
									<div style="width: 40px; margin-left:4%; display:inline-block;">
										<label for="negativ_<?php echo $l->id; ?>">
											<input type="radio" name="calificativ_value" id="negativ_<?php echo $l->id; ?>" value="x" />
											<img src="<?php echo $img_path.$calif_x; ?>" alt="Negativ" />
										</label>
									</div>
								</div>
								<div style="clear:both;"></div>
							</div>
							
							<input type="hidden" name="poster_id" value="<?php echo $uid; ?>" />
							<input type="hidden" name="dest_id" value="<?php echo $l->uid_winner; ?>" />
							<input type="hidden" name="id_anunt" value="<?php echo $l->id; ?>" />
							<input type="hidden" name="type" value="customer" />
							<input type="hidden" name="redirect" value="final" />
							</form>
							
							<div onClick="document.forms['calificativ_<?php echo $l->id; ?>'].submit();" class="sa_send_feedback sa_submit_feed">
								<?php echo JText::_('SAUTO_FEEDBACK_NOW_BUTTON'); ?>
							</div>
						<?php
						}
						?>
                </div>
            </div>
			    </div>
	<?php }}
        ?>

</div>




<script>
var isCollapsed=true;
		 if (document.getElementById('side_bar')){
			document.getElementById('side_bar').remove();
		 }

		 if (document.getElementById('gkTopBar')){
			 document.getElementById('gkTopBar').remove();
		 }

		 if (document.getElementById('m_table1')){
			document.getElementById('m_table1').remove();
		 }

		 if (document.getElementById('content119')){
			 document.getElementById('content9').style.all = "none";
		 }

		 if (document.getElementById('gkTopBar')){
			 document.getElementById('gkTopBar').remove();
		 }
		 if (document.getElementById('wrapper9')){
		 document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		 }
		jQuery('#menu-icon').on('click', toggleMenu);
		 jQuery('#filter-button').on('click', toggleFilterMenu);
        jQuery('.filter-category-name').on('click', collapseCategoryItems);
        jQuery('.category-item').on('click', getFilteredList);
        jQuery('.pic-container').on('click', getFilteredList);
		document.write('<style type="text/css" >#content9{width: 100% !important;' +
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
		document.write('<style type="text/css">@media="(max-width: 340px)"#gkMainbody table { width: 540px!important; display: block!important;  padding: 30px 0 20px 0;  overflow: hide;  max-width: 100%;</style>');s


       function getFilteredList(){
        var requestedUrl = 'http://localhost/android/index.php/component/sauto/?view=';
        var key = jQuery(this).data('category');
        var value = jQuery(this).data('id');
        var requestType;
        var obj = {};
        if (key === 'categories'){
            requestedUrl += 'categories&id='+value;
            requestType = "GET";
            obj["id"] = value;
        } else {
           requestedUrl += 'categories&id='+value;
            requestType = "POST";
            obj[key] = value;
        }

        jQuery('#filter-menu').hide(500);
        jQuery.ajax({
            type: requestType,
            url: requestedUrl,
            data: obj,
            contentType: "application/x-www-form-urlencoded"
        }).success(function(data) {
            var html = jQuery.parseHTML(data);
            jQuery('#main-container').html(jQuery(html).find('#m_visitors').find('#main-container'));
        }).error(function () {
            alert('error')
        });
    }

    function collapseCategoryItems(){
        var requiredSibling = jQuery(this).next('ul');
        if (jQuery(requiredSibling).is(":visible")){
            jQuery(requiredSibling).hide();
        }else{
            jQuery(requiredSibling).show();
        }
    }

    function toggleFilterMenu()
    {
        if (isCollapsed){
            isCollapsed = false;
            jQuery('#filter-menu').show(500);
        }
        else{
            isCollapsed = true;
            jQuery('#filter-menu').hide(500);
        }
    }
			
jQuery('#menu-icon').on('click', toggleMenu);
jQuery('.menu-option-text').on('click', redirectToMenuOption);
function toggleMenu () {
	   if (isCollapsed){
	        isCollapsed = false;
	        jQuery('#main-menu').show(500);
	    }
	    else{
	        isCollapsed = true;
	        jQuery('#main-menu').hide(500);
	    }
		}

	function redirectToMenuOption (event) {
		event.preventDefault();
		event.stopPropagation();
		var url=jQuery(event.target).data("href");
		alert(url);
   		window.location.href = url;
	}
</script>