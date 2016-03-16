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

$link_this = JRoute::_('index.php?option=com_sauto&view=my_request');
$link_filter = JRoute::_('index.php?option=com_sauto&view=requests_f&task=my');
?>
<div id="m_visitors">
<?php
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
			AND `a`.`uid_winner` = '0' 
			AND `a`.`uid_winner` != '".$uid."' 
			 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
			 GROUP BY `r`.`anunt_id` ";
$db->setQuery($query);
$db->execute();
$total = $db->getNumRows();
$width = 'style="width:100%;"';
if ($total == 0) {
	$app->setUserState('piese', '');
	//nu ai anunturi
	?>
	
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<?php $link_add = JRoute::_('index.php?option=com_sauto&view=requests'); ?>
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php 
			echo JText::_('SA_MISSING_REQUESTS_DEALER').'<br />';
			echo '<a href="'.$link_add.'" class="sa_lk_profile">'.JText::_('SA_DEALER_ADD_REQUEST_NOW').'</a>'; 
			echo ' '.JText::_('SAUTO_OR').' <a href="'.$link_filter.'" class="sa_lk_profile">'.JText::_('SA_FILTRE_RESET_ALL').'</a>';
			?>
		</div>
	</div>
	</div>
	<div style="clear:both;"></div>
</td>
		<td class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>';
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>
	<?php
} else {
$total_rezult = $total;
//$total_rezult = $db->loadResult();
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
$rezult_pagina = $sconfig->paginare;
//nr de pagini
$nr_pagini=ceil($total_rezult/$rezult_pagina); 

$page =& JRequest::getVar( 'page', '', 'get', 'string' );
if(isset($page) && is_numeric($page)){
    $pagina_curenta=(int)$page;
} else {
    $pagina_curenta=1;
}

if($pagina_curenta > $nr_pagini) {
    $pagina_curenta=$nr_pagini;
} elseif($pagina_curenta < 1) {
    $pagina_curenta=1;
}

$link = JRoute::_('index.php?option=com_sauto&view=my_request');

$interval=5;
 
if($pagina_curenta > (1+$interval)) {
	$paginare.='<a class="sa_page" href="'.$link.'&page=1">'.JText::_('SA_PRIMA_PAGINA').'</a>';
	$pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'">'.JText::_('SA_BACK_PAGE').'</a>';
} elseif (($pagina_curenta > 1) && ($pagina_curenta <= (1+$interval))) {
    $pagina_inapoi=$pagina_curenta-1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inapoi.'">'.JText::_('SA_BACK_PAGE').'</a>';
}

for($x=($pagina_curenta - $interval); $x < (($pagina_curenta + $interval) + 1); $x++) {
    if(($x > 0) && ($x <= $nr_pagini)){  
      if($pagina_curenta != $x){
        $paginare.='<a class="sa_page" href="'.$link.'&page='.$x.'">'.$x.'</a>';
      } else {
        $paginare.='<a class="sa_page"><span class="sa_page_current">'.$x.'</span></a>'; 
      }
    }
}


if(($pagina_curenta != $nr_pagini) && ($pagina_curenta < ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">'.JText::_('SA_FORWARD_PAGE').'</a>';
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$nr_pagini.'">'.JText::_('SA_LAST_PAGE').'</a>';
} elseif (($pagina_curenta != $nr_pagini) && ($pagina_curenta >= ($nr_pagini - $interval))){
    $pagina_inainte=$pagina_curenta+1;
    $paginare.='<a class="sa_page" href="'.$link.'&page='.$pagina_inainte.'">'.JText::_('SA_FORWARD_PAGE').'</a>';
}


$inceput=($pagina_curenta - 1) * $rezult_pagina;

//$query = "SELECT * FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `status_anunt` = '1' AND `is_winner` = '0' ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$query = "SELECT * FROM #__sa_raspunsuri AS `r` 
		JOIN #__sa_anunturi as `a` 
		ON `r`.`firma` = '".$uid."' 
		AND `r`.`anunt_id` = `a`.`id` 
		AND `a`.`uid_winner` = '0' 
		AND `a`.`uid_winner` != '".$uid."' 
		 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
		 GROUP BY `r`.`anunt_id`  DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();

//$i=1;
$image_path = JURI::base()."components/com_sauto/assets/users/";

?>

<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" style="100%">

<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top">
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

</td>
		
		<td class="sa_table_cell" valign="top">
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

</td>
		
				<td class="sa_table_cell" valign="top">
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
		</td>
	</tr>
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top">
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
		?>
		</td>
		<td class="sa_table_cell" valign="top">
		<?php
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
		?>
		</td>
		<td class="sa_table_cell" valign="top">
		<?php
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
		</td>
	</tr>
</table>



<table width="100%" class="sa_table_class" cellpadding="0"  cellspacing="0">
	<?php
	$i=1;
	foreach ($list as $l) {
	if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
	$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
		$image = 'anunt_type_'.$l->tip_anunt.'.png';
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td width="15%" valign="top" class="sa_table_cell"><center>';
			echo '<div><a href="'.$link_categ.'">'.JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt).'</a></div>';
			//verificare poze
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
			echo '<div><a href="'.$link_categ.'"><img src="'.$poza.'" alt="'.$alt.'" width="80" border="0" /></a></div>';
			/*echo '<div>';
				if (($l->pret == '') or ($l->pret == 0)) {
					echo JText::_('SAUTO_PRET_NESPECIFICAT'); 
				} else {
					echo JText::_('SAUTO_DISPLAY_PRICE').'<br />'.$l->pret.' '.JText::_('SAUTO_CURENCY_RON');
				}
			echo '</div>';*/
			echo '</center></td>';
			echo '<td width="55%" valign="top" class="sa_table_cell">';
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
			echo '<div class="sa_request_title"><a href="'.$link_anunt.'" class="sa_link_request">'.$l->titlu_anunt.'</a></div>';
			$data_add = explode(" ", $l->data_adaugarii);
			echo '<div>'.JText::_('SAUTO_SHOW_DATE').' '.$data_add[0].'</div>';
			echo '<div>'.substr(strip_tags($l->anunt), 0, 50).' ...</div>';
if ($l->accesorii_auto != 0) {
	echo '<div style="display:inline;">';
	//obtin accesoriu
	$query = "SELECT `accesorii` FROM #__sa_accesorii WHERE `id` = '".$l->accesorii_auto."'";
	$db->setQuery($query);
	$acc = $db->loadResult();
	echo '<div style="position:relative;float:left;" class="sa_accesories">'.$acc.'</div>';
	if ($l->subaccesorii_auto != 0) {
	$query = "SELECT `subaccesoriu` FROM #__sa_subaccesorii WHERE `id` = '".$l->subaccesorii_auto."'";
	$db->setQuery($query);
	$subacc = $db->loadResult();
	echo '<div style="position:relative;float:right;" class="sa_accesories">'.$subacc.'</div>';
	}
	echo '</div><div style="clear:both;"></div>';
}
if ($l->marca_auto != 0) {
	echo '<div style="display:inline;">';
	//obtin marca si modelul
	$query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$l->marca_auto."'";
	$db->setQuery($query);
	$marca = $db->loadResult();
	echo '<div style="position:relative;float:left;" class="sa_accesories">'.$marca.'</div>';
	if ($l->model_auto != 0) {
	$query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$l->model_auto."'";
	$db->setQuery($query);
	$model = $db->loadResult();	
	echo '<div style="position:relative;float:right;" class="sa_accesories">'.$model.'</div>';
	}
	echo '</div><div style="clear:both;"></div>';
}
			echo '</td>';
			echo '<td valign="top" class="sa_table_cell">';
			$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `p`.`abonament` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
			$db->setQuery($query);
			//echo $query;
			$userd = $db->loadObject();
			$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			echo '<div class="sa_request_title"><a href="'.$link_profile.'" class="sa_public_profile">'.$userd->fullname.'</a></div>';
			echo '<div>'.JText::_('SAUTO_DISPLAY_JUDET').': '.$userd->judet.'</div>';
			
			/*echo '<div class="sa_table_cell sa_phone">';
			echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
			echo '<span class="sa_phone_span">';
				//verific tipul de abonament
				if ($userd->abonament == 3) {
					echo $userd->telefon;
				} else {
					echo JText::_('SAUTO_PRET_ASCUNS');
				}
			echo '</span>';
			echo '</div>';
			echo '<br />'; */
			echo '<a href="'.$link_anunt.'" class="sa_link_box"><div class="sa_table_cell sa_phone sa_min_width_offer sa_hover">';
			echo '<span class="sa_oferte_span">';
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
			echo '</span>';
			echo '</div></a>';
			echo '<br />';
			//echo '<div class="sa_table_cell sa_phone">';
			//echo '<span class="sa_oferte_span">';
			$query = "SELECT count(*) FROM #__sa_comentarii WHERE `anunt_id` = '".$l->id."' AND `companie` = '".$uid."'";
			$db->setQuery($query);
			$comms = $db->loadResult();
			echo '<div style="position:relative;float:left;">';
				$link_comments = JRoute::_('index.php?option=com_sauto&view=all_comment_list');
				echo '<form action="'.$link_comments.'" method="post" name="sa_list_comm_'.$l->id.'" id="sa_list_comm_'.$l->id.'">';
				echo '<input type="hidden" name="anunt_id" value="'.$l->id.'" />';
				//echo '<input type="submit" value="'.JText::_('SAUTO_COMMENTS_LIST').' ('.$total_comms.')" />'; 
				echo '</form>';
				if ($comms != 0) {
					echo '<div onClick="document.forms[\'sa_list_comm_'.$l->id.'\'].submit();" class="sa_table_cell sa_phone sa_min_width_offer sa_cursor sa_hover">';
					echo '<span class="sa_oferte_span">';
				} else {
					echo '<div class="sa_table_cell sa_phone sa_min_width_offer sa_inactive">';
					echo '<span class="sa_oferte_span sa_black">';
				}
				
				//echo JText::_('SAUTO_COMMENTS_LIST').' ('.$total_comms.')';
					echo $comms.' '.JText::_('SAUTO_COMMENTS');
				echo '</span>';
				echo '</div>';
			echo '</div>';
			echo '</span>';
			echo '</div>';
			echo '</td>';
		echo '</tr>';
		//echo '<tr><td colspan="3" height="10"><hr /></td></tr>';
		if ($i == 5) {
			$style = 'sa-row0'; 
			echo '<tr class="sa_table_row '.$style.'">';
				echo '<td class="sa_table_cell" colspan="3">';
					$pozitionare = 'c';
					$categ = '';
					echo showAds($pozitionare, $categ);	
				echo '</td>';
			echo '</tr>'; 
		}
	$i++;
	}	
		?>
</table>
<?php
if ($total > $rezult_pagina) {
	echo $paginare;
}
echo '<br /><br />';

}
?>
</td>
		<td id="additional_td" class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				$categ = '';
				echo showAds($pozitionare, $categ);
			echo '</div>';
		?>
			</div>
		</td>
	</tr>
</table>
</div>
</div>
</div>
<!---==========================MOBILE==========================================================================================================================================================================--->
<div id="m_table" style="width:100%!important;background-color:#F9F9F9">
<?php
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
	?>
<div class = "fara_anunturi" style="width: 100%; height: 100px; background-color: #509EFF">
	</div>
<?php
} else {
$link = JRoute::_('index.php?option=com_sauto&view=my_request');
$query = "SELECT * FROM #__sa_raspunsuri AS `r` 
		JOIN #__sa_anunturi as `a` 
		ON `r`.`firma` = '".$uid."' 
		AND `r`.`anunt_id` = `a`.`id` 
		AND `a`.`uid_winner` = '0' 
		AND `a`.`uid_winner` != '".$uid."' 
		 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
		 GROUP BY `r`.`anunt_id`  DESC";
$db->setQuery($query);
$list = $db->loadObjectList();
$image_path = JURI::base()."components/com_sauto/assets/users/";

?>
<div class="mobile_class">
 <div class = "m_header">
          <img id="filter-button" class="menu-button" src="<?php echo $img_path?>filter-icon.png" />
</div>
 <div id="filter-menu" style="display: none;">
        <p class="filter-category-name">Categorie</p>
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
			<li class="category-item" data-category="judete" data-id="0">Toate Judetele</li>
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
				<li class="category-item" data-category="marci" data-id="0">Toate Marcile</li>
			<?php
            foreach ($marci as $mc) {?>
                <li class="category-item" data-category="marci" data-id="<?php echo $mc->id ?>"><?php echo $mc->marca_auto ?></li>
            <?php }
            ?>
        </ul>
    </div>


<div id="main-container" style="width:100%!important">
	<?php
	foreach ($list as $l1) {		
		$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l1->tip_anunt);
		$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l1->id);
		$image = 'anunt_type_'.$l1->tip_anunt.'.png';
		//verificare poze
			$query = "SELECT `poza`,`alt`, `owner` FROM #__sa_poze WHERE `id_anunt` = '".$l1->id."'";
			$db->setQuery($query);
			$pics = $db->loadObject();
			if ($pics->poza != '') {
				$poza = $image_path.$pics->owner."/".$pics->poza;
				$alt = $pics->alt;
			} else {
				$poza = $img_path.$image;
				$alt = '';
			}
			
			?>
	     <div class="request-item">
                <div class="pic-container" data-id="<?php echo $l1->tip_anunt ?>" data-category="categories">
                 <p>		
					<?php echo JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l1->tip_anunt) ?> </p>
                    	<a href="<?php echo $link_anunt ?>" class="sa_link_request"><?php echo $l1->titlu_anunt?></a>
						<img src="<?php echo $poza ?>" width="80" border="0" />
                </div>
                <div class="info-section">
                    <p>
                        <a href="<?php echo $link_anunt ?>"> <?php $l1->titlu_anunt ?></a>
                    </p>
                    <p>
                        <span><?php echo JText::_('SAUTO_SHOW_DATE') ?>: </span><?php echo $data_add[0]; ?>
                    </p>
                    <p> <?php echo strip_tags($l1->anunt) ?></p>

                    <?php if ($l1->marca_auto != 0) {
                        //obtin marca si modelul
                        $query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$l1->marca_auto."'";
                        $db->setQuery($query);
                        $marca = $db->loadResult();
                    }?>
                    <p> <?php echo $marca ?> </p>
                    <?php if ($l1->model_auto != 0) {
                        $query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$l1->model_auto."'";
                        $db->setQuery($query);
                        $model = $db->loadResult();
                    } ?>
                    <p> <?php echo $model ?> </p>

                </div>
                <div class="contact-section">
                    <p><span><?php echo JText::_('SAUTO_DISPLAY_JUDET') ?>: </span> <?php echo $userd->judet ?> </p>
                    <p style="background-color: #509EFF;" data-phone="<?php echo $userd->telefon ?>">
                        <img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />
                        <?php echo JText::_('SAUTO_TELEFON_ASCUNS') ?>
                    </p>
                    <?php
                    $query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `proprietar` = '".$l1->proprietar."' AND `anunt_id` = '".$l1->id."'";
                    $db->setQuery($query);
                    $oferte = $db->loadResult();
                    ?>
                    <p><?php echo $oferte == 0 ? JText::_('SAUTO_FARA_OFERTE') : $oferte == 1 ?
                            JText::_('SAUTO_O_OFERTA') : JText::_('SAUTO_NR_OFERTE'); ?></p>
                </div>
            </div>
	<?php
	}
		?>
</div>
<?php
if ($total > $rezult_pagina) {
	echo $paginare;
}
echo '<br /><br />';

}
?>
</div>
</div>
<script>
var isMobile = navigator.userAgent.contains('Mobile');
	if(!isMobile){
		document.getElementById('m_table').remove();
	}else {
		  var isCollapsed = true;
      		document.getElementById('m_visitors').remove();
		 if (document.getElementById('side_bar')){
			document.getElementById('side_bar').remove(); 
		 }
		 if (document.getElementById('gkTopBar')){
			 document.getElementById('gkTopBar').remove();
		 }
		
		 if (document.getElementById('m_table1')){
			document.getElementById('m_table1').remove();
		 }
		
		 if (document.getElementById('content9')){
			 document.getElementById('content9').style.all = "none";
		 }
		
		 if (document.getElementById('gkTopBar')){
			 document.getElementById('gkTopBar').remove();
		 }
		 if (document.getElementById('wrapper9')){
		 document.getElementById('wrapper9').getElementsByTagName('h1')[0].remove();
		 }
		document.write('<style type="text/css" >#content9{width: 100% !important;' + 
						'padding: 0 !important;margin: 0 !important;}#wrapper9{' +
						'width: 100% !important;}</style>'
		);
		document.write('<style type="text/css">@media="(max-width: 340px)"#gkMainbody table { width: 540px!important; display: block!important;  padding: 30px 0 20px 0;  overflow: hide;  max-width: 100%;</style>');
        jQuery('#filter-button').on('click', toggleFilterMenu);
        jQuery('.filter-category-name').on('click', collapseCategoryItems);
        jQuery('.category-item').on('click', getFilteredList);
        jQuery('.pic-container').on('click', getFilteredList);
    }

    function getFilteredList(){
        var requestedUrl = 'http://localhost/android/index.php/component/sauto/?view=my_request';
        var key = jQuery(this).data('category');
        var value = jQuery(this).data('id');
        var requestType;
        var obj = {};
        obj[key] = value;
        
        jQuery('#filter-menu').hide(500);
        jQuery.ajax({
            type: 'POST',
            url: requestedUrl,
            data: obj,
            contentType: "application/x-www-form-urlencoded"
        }).success(function(data) {
            var html = jQuery.parseHTML(data);
            jQuery('#main-container').html(jQuery(html).find('#m_table').find('#main-container'));
        }).error(function () {
          
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
</script>

<style type="text/css">
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