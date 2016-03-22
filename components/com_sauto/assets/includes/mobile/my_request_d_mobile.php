<style type="text/css">
	h1{
		display:none;
	}
    p{
        margin: 0;
    }
	.contact-section p{
		margin:1%;
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
<div id="m_visitors">
<div class = "m_header">
        <img id="filter-button" class="menu-button" style="right: 80px;"src="<?php echo $img_path?>filter-icon.png" />
        <img id="menu-icon" class="menu-button" src="<?php echo $img_path?>menu-icon.png" />
    </div>
	<div id="main-menu" style="display: none;">
        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_requests.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?view=requests"> Cereri </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_my_request.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php/component/sauto/?view=my_request"> Ofertele Mele </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_final_request.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?view=final_request"> Oferte Finalizate </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_alerts.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?view=alerts"> Alerte </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_edit_profile.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php/component/sauto/?view=edit_profile"> Editare profil </span>
        </div>

        <div class="menu-option">
          <img class="menu-option-pic" src="./components/com_sauto/assets/images/icon_logout.png" border="0">
          <span class="menu-option-text" data-href="/android/index.php?option=com_sauto&amp;view=logout"> Inchide Aplicatia </span>
        </div>
      </div>
    <div id="filter-menu" style="display: none;">
        <p class="filter-category-name">Oferte</p>
        <ul class="filter-category">
            <li class="category-item" data-category="oferte" data-id="2"> Toate Cererile </li>
            <li class="category-item" data-category="oferte" data-id="1"> Cu oferte </li>
            <li class="category-item" data-category="oferte" data-id="0"> Fara Oferte</li>
        </ul>

        <p class="filter-category-name">Piese</p>
        <ul class="filter-category">
            <li class="category-item" data-category="piese" data-id="0">Toate Cererile</li>
            <li class="category-item" data-category="piese" data-id="1">Piese Auto</li>
            <li class="category-item" data-category="piese" data-id="2">Inchirieri</li>
            <li class="category-item" data-category="piese" data-id="3">Auto Noi</li>
            <li class="category-item" data-category="piese" data-id="4">Auto Rulante</li>
            <li class="category-item" data-category="piese" data-id="5">Tractari Auto</li>
            <li class="category-item" data-category="piese" data-id="7">Accesorii Auto</li>
            <li class="category-item" data-category="piese" data-id="8">Service Auto</li>
            <li class="category-item" data-category="piese" data-id="9">Tuning</li>
        </ul>

        <p class="filter-category-name">Judet</p>
        <ul class="filter-category">
            <?php
            $query = "SELECT * FROM #__sa_judete ORDER BY `judet` ASC";
            $db->setQuery($query);
            $regions = $db->loadObjectList();
			 ?>
			<li class="category-item" data-category="piese" data-id="0">Toate Judetele</li>
            <?php
			foreach ($regions as $rg) { ?>
                <li class="category-item" data-category="judete" data-id="<?php echo $rg->id ?>"><?php echo $rg->judet ?></li>
            <?php }
            ?>
        </ul>

        <p class="filter-category-name">Marca</p>
        <ul class="filter-category">
            <?php
            $query = "SELECT * FROM #__sa_marca_auto WHERE `published` = '1' ORDER BY `marca_auto` ASC";
            $db->setQuery($query);
            $marci = $db->loadObjectList();
			?>
			<li class="category-item" data-category="piese" data-id="0">Toate Marcile</li>
           <?php
			foreach ($marci as $mc) {?>
                <li class="category-item" data-category="marci" data-id="<?php echo $mc->id ?>"><?php echo $mc->marca_auto ?></li>
            <?php }
            ?>
        </ul>
    </div>

		
    <div id="main-container">
        <?php
        $i=1;
        foreach ($list as $l) {
            $image = 'anunt_type_'.$l->tip_anunt.'.png';
            $link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);

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
            $data_add = explode(" ",$l->data_adaugarii);
            ?>
		<div class="request-item">
		<?php 
			//verificare poze
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
		<div class="pic-container" data-id="<?php echo $l->tip_anunt ?>" data-category="categories">
			<?php echo '<a href="'.$link_categ.'" class="sa_lk_profile">'.JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt); ?>
					<img src="<?php echo $poza ?>" width="80" border="0" /></a>
		</div>	
		 <div class="info-section">
			<?php
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
			echo '<p class="sa_request_title"><a href="'.$link_anunt.'" class="sa_link_request">'.$l->titlu_anunt.'</a></p>';
			$data_add = explode(" ",$l->data_adaugarii);
			echo '<p>'.substr(strip_tags($l->anunt), 0, 50).' ...</p>';
			if ($l->marca_auto != 0) {

				//obtin marca si modelul
				$query = "SELECT `marca_auto`, `published` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
				$db->setQuery($query);
				$marca = $db->loadObject();
				$query = "SELECT `model_auto`, `published` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
				$db->setQuery($query);
				$model = $db->loadObject();
					echo '<p style="position:relative">'.JText::_('SAUTO_SHOW_MARCA').' ';
						if ($marca->published == 1) {
							echo $marca->marca_auto;
						} else {
							echo JText::_('SAUTO_MARCA_NEPUBLICATA');
						}
					echo '</p>';
					echo '<p style="position:relative">'.JText::_('SAUTO_SHOW_MODEL').' ';
						if ($model->published == 1) {
							echo $model->model_auto;
						} else {
							echo JText::_('SAUTO_MODEL_NEPUBLICAT');
						}
					echo '</p>';
			}
			echo '<p>'.JText::_('SAUTO_SHOW_DATE').' '.$data_add[0].'</p>';
			?>
			
			</div>
		 <div class="contact-section">
			<?php
			$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `p`.`abonament` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
			$db->setQuery($query);
			$userd = $db->loadObject();
			$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			echo '<p class="sa_request_title"><a href="'.$link_profile.'" class="sa_link_request">'.$userd->fullname.'</a></p>';
			echo '<p>'.JText::_('SAUTO_DISPLAY_JUDET').': '.$userd->judet.'</p>';
			?>
		
			<?php
			echo '<p style="width:100%;" class="sa_phone sa_phone_oferte "><a href="'.$link_anunt.'" class="sa_link_box">';
			echo '<span class="sa_oferte_span">';
				$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `proprietar` = '".$l->proprietar."' AND `anunt_id` = '".$l->id."'";
				$db->setQuery($query);
				$oferte = $db->loadResult();
				if ($oferte == 1) {
					echo JText::_('SAUTO_O_OFERTA');
				} elseif ($oferte == 0) {
					echo JText::_('SAUTO_FARA_OFERTE');
				} else {
					echo $oferte.' '.JText::_('SAUTO_NR_OFERTE');
				}
			echo '</span>';
			echo '</a></p>';
				$query = "SELECT count(*) FROM #__sa_comentarii WHERE `anunt_id` = '".$l->id."' AND `companie` = '".$uid."'";
				$db->setQuery($query);
				$comms = $db->loadResult();
				$link_comments = JRoute::_('index.php?option=com_sauto&view=all_comment_list');
			?>
			<p style="width:100%;">
				<form action="<?php echo $link_comments; ?>" method="post" name="<?php echo 'sa_list_comm_'.$l->id; ?>" id="<?php echo 'sa_list_comm_'.$l->id; ?>">
					<input type="hidden" name="anunt_id" value="<?php echo $l->id; ?>" />
				</form>
			<?php
				if ($comms != 0) {
					echo '<p onClick="document.forms[\'sa_list_comm_'.$l->id.'\'].submit();" class="sa_phone sa_cursor sa_hover">';
					echo '<span class="sa_oferte_span">';
				} else {
					echo '<p class="sa_phone sa_inactive">';
					echo '<span class="sa_oferte_span sa_black">';
				}
					echo $comms.' '.JText::_('SAUTO_COMMENTS');
					?>
						</span>
					</p>
			</p>
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

