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
</style>
<?php
defined('_JEXEC') || die('=;)');

$link_this = JRoute::_('index.php?option=com_sauto&view=my_request');
$link_filter = JRoute::_('index.php?option=com_sauto&view=requests_f&task=my');
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
			AND `a`.`uid_winner` = '0' 
			AND `a`.`uid_winner` != '".$uid."' 
			 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
			 GROUP BY `r`.`anunt_id` ";
$db->setQuery($query);
$db->execute();
$total = $db->getNumRows();
if ($total == 0) {
	$app->setUserState('piese', '');
	//nu ai anunturi
	require_once("fara_anunturi.php");
} else {
$link = JRoute::_('index.php?option=com_sauto&view=my_request');
?>
<?php 
$query = "SELECT * FROM #__sa_raspunsuri AS `r` 
		JOIN #__sa_anunturi as `a` 
		ON `r`.`firma` = '".$uid."' 
		AND `r`.`anunt_id` = `a`.`id` 
		AND `a`.`uid_winner` = '0' 
		AND `a`.`uid_winner` != '".$uid."' 
		 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
		 GROUP BY `r`.`anunt_id` DESC ";
$db->setQuery($query);
$list = $db->loadObjectList();
echo '<input  type="hidden" id="anunt_id" value="'.$id.'"/>';
$image_path = JURI::base()."components/com_sauto/assets/users/";
?>

<div id="m_visitors">
<?php  require_once('menu_filter.php');?>
	<form action="<?php echo $link_this; ?>" method="post">
				<select name="piese" onchange="this.form.submit()">
					<option value="0" <?php if ($ck_piese == 0) { echo ' selected '; } ?>><?php echo JText::_('SA_FILTRE_TOATE_OFERTELE'); ?></option>
					<?php
					$query = "SELECT * FROM #__sa_tip_anunt WHERE `published` = '1'";
					$db->setQuery($query);
					$tips = $db->loadObjectList();
					foreach ($tips as $tps) {
						echo '<option value="'.$tps->id.'" ';
						if ($ck_piese == $tps->id) { echo ' selected '; } 
					echo '>'.$tps->tip.'</option>';
					}
					?>
				</select>
			</form>
<form action="<?php echo $link_this; ?>" method="post">
	<select name="judete" onchange="this.form.submit()">
		<option value="0" <?php if ($ck_judete == 0) { echo ' selected '; } ?>><?php echo JText::_('SA_FILTRE_TOATE_JUDETELE'); ?></option>
		<?php
		$query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
		$db->setQuery($query);
		$regions = $db->loadObjectList();
		foreach ($regions as $rg) {
			echo '<option value="'.$rg->id.'"';
				if ($ck_judete == $rg->id) { echo ' selected '; }
			echo '>'.$rg->judet.'</option>';
		}
		?>
	</select>
</form>
<form action="<?php echo $link_this; ?>" method="post">
	<select name="marci" onchange="this.form.submit()">
		<option value="0" <?php if ($ck_marci == 0) { echo ' selected '; } ?>><?php echo JText::_('SA_FILTRE_TOATE_MARCILE'); ?></option>
		<?php
		$query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
		$db->setQuery($query);
		$marci = $db->loadObjectList();
		foreach ($marci as $mc) {
			echo '<option value="'.$mc->id.'"';
				if ($ck_marci == $mc->id) { echo ' selected '; }
			echo '>'.$mc->marca_auto.'</option>';
		}
		?>
	</select>
</form>
		<?php
		if ($ck_piese == 1) {
			?>
			<form action="<?php echo $link_this; ?>" method="post">
			<select name="tip_piesa" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('SAUTO_VREAU_ORICE_PIESA'); ?></option>
				<option value="1" <?php if ($tip_piesa == 1) { echo ' selected '; } ?>><?php echo JText::_('SAUTO_VREAU_PIESA_NOUA'); ?></option>
				<option value="2" <?php if ($tip_piesa == 2) { echo ' selected '; } ?>><?php echo JText::_('SAUTO_VREAU_PIESA_SH'); ?></option>
			</select>
			</form>
			<?php
		} elseif ($ck_piese == 4) {
			?>
			<form action="<?php echo $link_this; ?>" method="post">
			<?php echo JText::_('SAUTO_BUGET_ALOCAT_MAXIM'); ?>
			<br />
			<input type="text" name="pret_maxim" value="<?php echo $pret_maxim; ?>" size="4" />
			<?php
			$query = "SELECT * FROM #__sa_moneda WHERE `published` = '1'";
			$db->setQuery($query);
			$monede = $db->loadObjectList();
			echo '<select name="s_moneda">';
				foreach ($monede as $mon) {
					echo '<option value="'.$mon->id.'"';
						if ($mon->id == $s_moneda) { echo ' selected '; }
					echo '>'.$mon->m_scurt.'</option>';
				}
			echo '</select>';
			?>
			<br />
			<input type="submit" value="<?php echo JText::_('SAUTO_FORM_SET_BUTTON'); ?>" />
			</form>
			<?php
		}
		if ($ck_judete != '') {
			if ($ck_judete != 0) {
				?>
<form action="<?php echo $link_this; ?>" method="post">
	<select name="orase" onchange="this.form.submit()">
		<option value="0" <?php if ($ck_orase == 0) { echo ' selected '; } ?>><?php echo JText::_('SA_FILTRE_TOATE_ORASELE'); ?></option>
		<?php
		$query = "SELECT * FROM #__sa_localitati WHERE `jid` = '".$ck_judete."' AND `published` = '1' ORDER BY `localitate` ASC";
		$db->setQuery($query);
		$cities = $db->loadObjectList();
		foreach ($cities as $ct) {
			echo '<option value="'.$ct->id.'"';
				if ($ck_orase == $ct->id) { echo ' selected '; }
			echo '>'.$ct->localitate.'</option>';
		}
		?>
	</select>
</form>
				<?php
			}
		}
	if ($ck_marci != '') {
			if ($ck_marci != 0) {
				?>
<form action="<?php echo $link_this; ?>" method="post">
	<select name="modele" onchange="this.form.submit()">
		<option value="0" <?php if ($ck_modele == 0) { echo ' selected '; } ?>><?php echo JText::_('SA_FILTRE_TOATE_MODELELE'); ?></option>
		<?php
		$query = "SELECT * FROM #__sa_model_auto WHERE `mid` = '".$ck_marci."' AND `published` = '1' ORDER BY `model_auto` ASC";
		$db->setQuery($query);
		$models = $db->loadObjectList();
		foreach ($models as $md) {
			echo '<option value="'.$md->id.'"';
				if ($ck_modele == $md->id) { echo ' selected '; }
			echo '>'.$md->model_auto.'</option>';
		}
		?>
	</select>
</form>
				<?php
			}
		}
		?>
<div class = "main-container">
	<?php
	foreach ($list as $l) {
		$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
		$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
		$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
		$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
		$image = 'anunt_type_'.$l->tip_anunt.'.png';
		$query = "SELECT `poza`,`alt`, `owner` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."'";
		$db->setQuery($query);
		$pics = $db->loadObject();
			if ($pics->poza != '') {
				$poza = $image_path.$pics->owner."/".$pics->poza;
				$alt = $pics->alt;
			} else {
				$poza = $img_path.$image;
				$alt = '';
			}
			$data_add = explode(" ", $l->data_adaugarii);
			?>
			<div class="request-item">	
				<div class="pic-container" data-id="<?php echo $l->tip_anunt; ?>" data-category="categories">
					<img src="<?php echo $poza; ?>" width="80" border="0" />
				</div>	
				<div class="info-section">
                    <p>
                        <a href="<?php echo $link_anunt; ?>"> <?php $l->titlu_anunt ?></a>
                    </p>
                    <p> <?php echo substr(strip_tags($l->anunt), 0, 50); ?></p>
					<?php 
					if ($l->accesorii_auto != 0) {
						$query = "SELECT `accesorii` FROM #__sa_accesorii WHERE `id` = '".$l->accesorii_auto."'";
						$db->setQuery($query);
						$acc = $db->loadResult();
					?>
						<p> <?php echo $acc; ?> </p>
					<?php
						if ($l->subaccesorii_auto != 0) {
							$query = "SELECT `subaccesoriu` FROM #__sa_subaccesorii WHERE `id` = '".$l->subaccesorii_auto."'";
							$db->setQuery($query);
							$subacc = $db->loadResult();
						}
					?> 
						<p> <?php echo $subacc; ?> </p>
					<?php
						}
					?>
					
					
                    <?php if ($l->marca_auto != 0)
						{
									//obtin marca si modelul
									$query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
									$db->setQuery($query);
									$marca = $db->loadResult();
								?>
								<p> <?php echo $marca; ?> </p>
								<?php if ($l->model_auto != 0) {
									$query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
									$db->setQuery($query);
									$model = $db->loadResult();
								} 
								?>
									<p> <?php echo $model; ?> </p>
								<?php
						}
					?>
                   
					 <p>
                        <span><?php echo JText::_('SAUTO_SHOW_DATE'); ?>: </span><?php echo $data_add[0]; ?>
                    </p>
                </div>
			<div class="contact-section">
	<?php 		
		$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `p`.`abonament` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
			$db->setQuery($query);
			$userd = $db->loadObject();
			$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			echo '<div class="sa_request_title"><a href="'.$link_profile.'" class="sa_public_profile">'.$userd->fullname.'</a></div>';
	?>
				<p><span><?php echo JText::_('SAUTO_DISPLAY_JUDET') ?>: </span> <?php echo $userd->judet ?> </p>

	</div>
	<div id="oferte_section">
			<a href="<?php echo $link_anunt; ?>" class="sa_link_box">
				<div style="position:relative;float:right; margin-right:2%;"class="sa_phone sa_min_width_offer sa_hover">
					<span class="sa_oferte_span">
						<?php
							$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$l->id."'";
							$db->setQuery($query);
							$oferte = $db->loadResult();
							if ($oferte == 1) {
								echo JText::_('SAUTO_O_OFERTA');
							} elseif ($oferte == 0) {
								echo JText::_('SAUTO_FARA_OFERTE');
							} else {
								echo $oferte.' '.JText::_('SAUTO_NR_OFERTE');
							}
						?>
					</span>
				</div>
			</a>
			<?php
				$query = "SELECT count(*) FROM #__sa_comentarii WHERE `anunt_id` = '".$l->id."' AND `companie` = '".$uid."'";
				$db->setQuery($query);
				$comms = $db->loadResult();
				$link_comments = JRoute::_('index.php?option=com_sauto&view=all_comment_list');
			?>
			<div style="position:relative;float:left; margin-left:2%;">
			<form action="<?php echo $link_comments; ?>" method="post" name="<?php echo 'sa_list_comm_'.$l->id; ?>" id="<?php echo 'sa_list_comm_'.$l->id; ?>">
				<input type="hidden" name="anunt_id" value="<?php echo $l->id; ?>" />
			</form>
			<?php
				if ($comms != 0) {
					echo '<p onClick="document.forms[\'sa_list_comm_'.$l->id.'\'].submit();" class="sa_phone sa_min_width_offer sa_cursor sa_hover">';
					echo '<span class="sa_oferte_span">';
				} else {
					echo '<p class="sa_phone sa_min_width_offer sa_inactive">';
					echo '<span class="sa_oferte_span sa_black">';
				}
					echo $comms.' '.JText::_('SAUTO_COMMENTS');
					?>
				</span>
				</p>
				</span>
				</p>
				
			</div>
			
			</div>
			</div>
	<?php
}	
}
?>

</div>
</div>
<script type="text/javascript">
    var isCollapsed = true;
	var anuntId=document.getElementById("anunt_id").value;
		document.getElementById('gkTopBar').remove();
		document.getElementById('side_bar').style.display = "none";
		document.getElementById('content9').style.all = "none";
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);

        jQuery('#filter-button').on('click', toggleFilterMenu);
        jQuery('.filter-category-name').on('click', collapseCategoryItems);
        jQuery('.category-item').on('click', getFilteredList);
        jQuery('.pic-container').on('click', getFilteredList);
       function getFilteredList(){
        var requestedUrl = 'http://localhost/android/index.php/component/sauto/?view=';
        var key = jQuery(this).data('category');
        var value = jQuery(this).data('id');
        var requestType;
        var obj = {};
        if (key === 'categories'){
            requestedUrl += 'categories&id='+anuntId;
            requestType = "GET";
            obj["id"] = value;
        } else {
           requestedUrl += 'categories&id='+anuntId;
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
   		window.location.href = url;
	}
</script>

