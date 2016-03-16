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
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
$link_this = JRoute::_('index.php?option=com_sauto&view=categories&id='.$id);
$link_filter = JRoute::_('index.php?option=com_sauto&view=requests_f&id='.$id.'&cat=1');

##################
$db_oferte = "";
$db_piese = "";
$app =& JFactory::getApplication();
$oferte =& JRequest::getVar( 'oferte', '', 'post', 'string' );
$piese =& JRequest::getVar( 'piese', '', 'post', 'string' );
$judete =& JRequest::getVar( 'judete', '', 'post', 'string' );
$marci =& JRequest::getVar( 'marci', '', 'post', 'string' );
$modele =& JRequest::getVar( 'modele', '', 'post', 'string' );
$orase =& JRequest::getVar( 'orase', '', 'post', 'string' );


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
	$db_piese .= "";
##################
$max_litere = 80;


$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `status_anunt` = '1' AND `is_winner` = '0' AND `tip_anunt` = '".$id."' 
".$db_oferte." ".$db_piese." ".$db_judete." ".$db_marci." ".$db_orase." ".$db_modele." ";
$db->setQuery($query);
$total = $db->loadResult();
$width = 'style="width:800px;"';
if ($total == 0) {
	//nu ai anunturi
	?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_REQUESTS_THIS_FILTER'); ?>
		<br />
		<a href="<?php echo $link_filter; ?>"><?php echo JText::_('SA_FILTRE_RESET_ALL'); ?></a>
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
################################################

$total_rezult = $total;
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

$link = JRoute::_('index.php?option=com_sauto&view=categories&id='.$id);

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

$query = "SELECT * FROM #__sa_anunturi WHERE `status_anunt` = '1' AND `is_winner` = '0' AND `tip_anunt` = '".$id."' ".$db_oferte." ".$db_piese." ".$db_judete." ".$db_marci." ".$db_orase." ".$db_modele." ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();

//echo '<table class="gym_table" width="100%">';
//echo '<tr class="gym_row"><td class="gym_adm_head_2">'.JText::_('GYM_NR_CRT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_USERNAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_NAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_EMAIL').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ABOMAMENT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ACTIONS').'</td></tr>';
$i=1;
$image_path = JURI::base()."components/com_sauto/assets/users/";
	
?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top">
<form action="<?php echo $link_this; ?>" method="post">
	<select name="oferte" onchange="this.form.submit()">
		<option value="2" <?php if ($ck_oferte == 2) { echo ' selected '; } ?>><?php echo JText::_('SA_FILTRE_TOATE_OFERTELE'); ?></option>
		<option value="0" <?php if ($ck_oferte == 0) { echo ' selected '; } ?>><?php echo JText::_('SA_FILTRE_FARA_OFERTE'); ?></option>
		<option value="1" <?php if ($ck_oferte == 1) { echo ' selected '; } ?>><?php echo JText::_('SA_FILTRE_CU_OFERTE'); ?></option>
	</select>
</form>
		</td>
		<td class="sa_table_cell" valign="top">
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
		<td class="sa_table_cell" valign="top"></td>
		<td class="sa_table_cell" valign="top">
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

<?php
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

	
	 
?>


<table  class="sa_table_class">
	<?php
	$i=1;
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
		$image = 'anunt_type_'.$l->tip_anunt.'.png';
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td width="15%" valign="top" class="sa_table_cell"><center>';
			echo '<div><a href="'.$link_categ.'">'.JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt).'</a></div>';
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
			echo '<div><a href="'.$link_categ.'"><img src="'.$poza.'" alt="'.$alt.'" width="80" border="0" /></a></div>';
			/*echo '<div>';
				if (($l->pret == '') or ($l->pret == 0)) {
					echo JText::_('SAUTO_PRET_NESPECIFICAT'); 
				} else {
					echo JText::_('SAUTO_DISPLAY_PRICE').'<br />'.$l->pret.' '.JText::_('SAUTO_CURENCY_RON');
				}
			echo '</div>';*/
			echo '</center></td>';
			echo '<td width="45%" valign="top" class="sa_table_cell">';
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
			echo '<div class="sa_request_title"><a href="'.$link_anunt.'" class="sa_link_request">'.$l->titlu_anunt.'</a></div>';
			echo '<div>'.JText::_('SAUTO_SHOW_DATE').' '.$l->data_adaugarii.'</div>';
			echo '<div>'.substr(strip_tags($l->anunt), 0, $max_litere).'</div>';
			
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
			$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
			$db->setQuery($query);
			//echo $query;
			$userd = $db->loadObject();
			$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			echo '<div class="sa_request_title"><a class="sa_public_profile" href="'.$link_profile.'">'.$userd->fullname.'</a></div>';
			echo '<div>'.JText::_('SAUTO_DISPLAY_JUDET').': '.$userd->judet.'</div>';
			echo '<div>Tel.: '.JText::_('SAUTO_TELEFON_ASCUNS').'</div>';
			echo '<a href="'.$link_anunt.'">';
			echo '<div class="sa_table_cell sa_phone sa_min_width_phone sa_hover">';
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
			echo '</div>';
			echo '</a>';
			echo '</td>';
		echo '</tr>';
		//echo '<tr><td colspan="3" height="10"><hr /></td></tr>';
		
		if ($i == 5) {	
				$style = 'sa-row0'; 
				echo '<tr class="sa_table_row '.$style.'">';
					echo '<td class="sa_table_cell" colspan="3">';
						//echo $rec->cod_reclama;	
						$pozitionare = 'c';
						echo showAds($pozitionare, $id);
					echo '</td>';
				echo '</tr>';	
		}
		$i++;
	}
	?>
</table>
		</td>
		<td class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				echo showAds($pozitionare, $id);
			echo '</div>';
			echo '<div>'.$show_side_content.'</div>';	
				
			?>
			</div>
		</td>
	</tr>
</table>


<?php
if ($total > $rezult_pagina) {
	echo $paginare;
}
echo '<br /><br />';

}
?>

