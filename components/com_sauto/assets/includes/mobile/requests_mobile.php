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
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$link_this = JRoute::_('index.php?option=com_sauto&view=requests');
$link_filter = JRoute::_('index.php?option=com_sauto&view=requests_f');
//verificam variabilele.....
$db_oferte = "";
$db_piese = "";
$app =& JFactory::getApplication();
$oferte =& JRequest::getVar( 'oferte', '', 'post', 'string' );
$piese =& JRequest::getVar( 'piese', '', 'post', 'string' );
$judete =& JRequest::getVar( 'judete', '', 'post', 'string' );
$marci =& JRequest::getVar( 'marci', '', 'post', 'string' );
$modele =& JRequest::getVar( 'modele', '', 'post', 'string' );
$orase =& JRequest::getVar( 'orase', '', 'post', 'string' );
$width = 'style="width:800px;"';

//echo 'var >>>>'.$marci.'<br />';
if ($marci != '') {
	$app->setUserState('marci', $marci);
}

if ($modele != '') {
	$app->setUserState('modele', $modele);
}

if ($judete != '') {
	$app->setUserState('judete', $judete);
}

if ($orase != '') {
	$app->setUserState('orase', $orase);
}

if ($oferte == '1') {
	$app->setUserState('oferte', '1');
} elseif ($oferte == '0') {
	$app->setUserState('oferte', '0');
} elseif ($oferte == '2') {
	$app->setUserState('oferte', '2');
}

if ($piese != '') {
	$app->setUserState('piese', $piese);
}

//creem variabilele
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

$ck_judete = $app->getUserState('judete');
if ($ck_judete == 0) {
	$db_judete = "";
} else {
	$db_judete = " AND `judet` = '".$ck_judete."'";
}

$ck_orase = $app->getUserState('orase');
if ($ck_orase == 0) {
	$db_orase = "";
} else {
	$db_orase = " AND `city` = '".$ck_orase."'";
}

//echo '>>> judete > '.$ck_judete.'<br />';
//echo '>>> marci > '.$ck_marci.'<br />';
$ck_oferte = $app->getUserState('oferte');
if ($ck_oferte == '') { $ck_oferte = 2; }
if ($ck_oferte == 1) {
	$db_oferte .= " AND `oferte` != '0'";
} elseif ($ck_oferte == 0) {
	$db_oferte .= " AND `oferte` = '0'";
} elseif ($ck_oferte == '2') {
	$db_oferte .= "";
}
//echo 'var oferte >>>> '.$db_oferte.'<br />';

$ck_piese = $app->getUserState('piese');
//echo 'chk oferte >>>> '.$ck_oferte.'<br />';
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
//echo 'var marci >>>> '.$db_marci.'<br />';
//start script
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `status_anunt` = '1' AND `is_winner` = '0' ".$db_oferte." ".$db_piese." ".$db_judete." ".$db_marci." ".$db_orase." ".$db_modele." ";
$db->setQuery($query);
$total = $db->loadResult();
//echo $query;
if ($total == 0) {
	$app->setUserState('piese', '');
	$app->setUserState('oferte', '');
	//nu ai anunturi
	require_once('fara_anunturi.php');
} else {
################################################
$total_rezult = $total;
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$link = JRoute::_('index.php?option=com_sauto&view=requests');
$query = "SELECT * FROM #__sa_anunturi WHERE `status_anunt` = '1' AND `is_winner` = '0'  ".$db_oferte." ".$db_piese." ".$db_judete." ".$db_marci." ".$db_orase." ".$db_modele." ORDER BY `id` DESC";
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = JURI::base()."components/com_sauto/assets/users/";
//verificam nivelul de acces
$query = "SELECT `abonament` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$types = $db->loadResult();
$view_phone = 0;
	//verificam abonamentul
	if ($types == 3) {
		$view_phone = 1;
	}

JHTML::_('behavior.tooltip');
	if ($ck_piese == 0) {
		//toate categoriile
		$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
		$db->setQuery($query);
		$sconfig = $db->loadObject();
		//echo $sconfig->id_article_all;
		//obtin cat id
		$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$sconfig->id_article_all."'";
		$db->setQuery($query);
		$intro = $db->loadResult();
		$show_side_content = $intro;
	} else {
		$query = "SELECT `article_id` FROM #__sa_tip_anunt WHERE `id` = '".$ck_piese."' AND `published` = '1'";
		$db->setQuery($query);
		$article_id = $db->loadResult();
		$query = "SELECT `introtext` FROM #__content WHERE `id` = '".$article_id."'";
		$db->setQuery($query);
		$intro = $db->loadResult();
		$show_side_content = $intro;
	}
########################
	if ($ck_piese == 0) {
		//prelucram reclamele
		$query = "SELECT count(*) FROM #__sa_reclame WHERE `pozitionare` = 'l' AND `published` = '1' AND `maxim_afisari` > `afisari_curente`";
	} else {
		$query = "SELECT count(*) FROM #__sa_reclame WHERE `pozitionare` = 'l' AND `lista` = '".$ck_piese."' AND `published` = '1' AND `maxim_afisari` > `afisari_curente`";
	}
	$db->setQuery($query);
	$tot_recl = $db->loadResult();

	if ($tot_recl != 0) {
		//obtinem un rezultat randon din data base
		if ($ck_piese == 0) {
			$query = "SELECT * FROM #__sa_reclame WHERE `pozitionare` = 'l' AND `published` = '1' AND `maxim_afisari` > `afisari_curente` ORDER BY rand() LIMIT 1";
		} else {
			$query = "SELECT * FROM #__sa_reclame WHERE `pozitionare` = 'l' AND `lista` = '".$ck_piese."' AND `published` = '1' AND `maxim_afisari` > `afisari_curente` ORDER BY rand() LIMIT 1";
		}
		$db->setQuery($query);
		$recls = $db->loadObject();
		$show_side_reclama = $recls->cod_reclama;

		//actualizam numarul de vizualizari
		if ($recls->necontorizat == 0) {
			$new_afisari2 = $recls->afisari_curente + 1;
			$query = "UPDATE #__sa_reclame SET `afisari_curente` = '".$new_afisari2."' WHERE `id` = '".$recls->id."'";
			$db->setQuery($query);
			$db->query();
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
			
			echo '<p style="width:100%;"class="sa_table_cell sa_phone sa_phone_oferte">';
			echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
			echo '<span class="sa_phone_span">';
				//afisam telefonul
				if ($view_phone == 0) {
					echo JText::_('SAUTO_TELEFON_ASCUNS');
				} else {
					echo $userd->telefon;
				}
								
			echo '</span>';
			echo '</p>';

			echo '<a href="'.$link_anunt.'" class="sa_link_box"><p style="width:100%;" class="sa_table_cell sa_phone sa_phone_oferte sa_padding">';
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
			echo '</p></a>';
			?>
		</div>
		</div>
        <?php }
        ?>
    </div>
</div>
<?php } ?>
<script type="text/javascript">
    var isCollapsed = true;

	var isMobile = navigator.userAgent.contains('Mobile');
    if (!isMobile){
        jQuery('#m_visitors').remove();
    }
	else {
        jQuery('.m_table').remove();
        jQuery('#side_bar').remove();
		jQuery('#gkTopBar').remove();
        jQuery('#filter-button').on('click', toggleFilterMenu);
        jQuery('.filter-category-name').on('click', collapseCategoryItems);
        jQuery('.category-item').on('click', getFilteredList);
        jQuery('.pic-container').on('click', getFilteredList);
    }

    function getFilteredList(){
        var requestedUrl = 'http://localhost/android/index.php/component/sauto/?view=';
        var key = jQuery(this).data('category');
        var value = jQuery(this).data('id');
        var requestType;
        var obj = {};
        if (key === 'categories'){
            requestedUrl += 'categories';
            requestType = "GET";
            obj["id"] = value;
        } else {
            requestedUrl += 'requests';
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
	document.getElementsByTagName('h1')[0].remove();
		
		jQuery('#menu-icon').on('click', toggleMenu);

		jQuery('.menu-option-text').on('click', redirectToMenuOption);

	var isMenuCollapsed = true;
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
		var url=jQuery(event.target).data("href");
   		window.location.href = url;
	}
</script>

