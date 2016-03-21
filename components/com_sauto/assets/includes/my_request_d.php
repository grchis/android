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
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($useragent,'Mobile')){
require_once('/mobile/my_request_d_mobile.php');
}else{
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
<?php } ?>