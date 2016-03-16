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
		AND `a`.`uid_winner` = '".$uid."' 
		 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
		 GROUP BY `r`.`anunt_id` ";
$db->setQuery($query);
$db->execute();
$total = $db->getNumRows();
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
			<?php $link_add = JRoute::_('index.php?option=com_sauto&view=requests'); ?>
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php 
		echo JText::_('SA_MISSING_FINAL_REQUESTS_DEALER').'<br />'; 
		echo '<a href="'.$link_filter.'" class="sa_lk_profile">'.JText::_('SA_FILTRE_RESET_ALL').'</a>';?>
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

$link = JRoute::_('index.php?option=com_sauto&view=final_request');

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
		AND `a`.`uid_winner` = '".$uid."' 
		 ".$db_piese."  ".$db_judete."  ".$db_marci." ".$db_orase." ".$db_modele." 
		 GROUP BY `r`.`anunt_id` ORDER BY `a`.`data_castigare` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();

$image_path = JURI::base()."components/com_sauto/assets/users/";
require("calificativ.php");

?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>

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
		
<table width="100%" class="sa_table_class" border="0">
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
	?>
	<tr class="sa_table_row <?php echo $style;?>">
		<td width="15%" valign="top" class="sa_table_cell">
		<center>
			<div>
				<a href="<?php echo $link_categ; ?>" class="sa_lk_profile">
					<?php echo JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt); ?>
				</a>
			</div>
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
			<div>
				<a href="<?php echo $link_categ; ?>" class="sa_lk_profile">
					<img src="<?php echo $poza; ?>" alt="<?php echo $alt; ?>" width="80" border="0" />
				</a>
			</div>
			
			<div>
			<?php //obtin pret + moneda
			$query = "SELECT `r`.`pret_oferit`, `m`.`m_scurt` FROM #__sa_raspunsuri as `r` JOIN #__sa_moneda as `m` ON `r`.`anunt_id` = '".$l->id."' AND `r`.`status_raspuns` = '1' AND `r`.`moneda` = `m`.`id`";
			$db->setQuery($query);
			$curency = $db->loadObject();
			echo JText::_('SAUTO_DISPLAY_PRICE').'<br />'.$curency->pret_oferit.' '.$curency->m_scurt;
			?>
			</div>
		</center>
		</td>
		<td width="55%" valign="top" class="sa_table_cell">
			<?php
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
			?>
			<div class="sa_request_title">
				<a href="<?php echo $link_anunt; ?>" class="sa_link_request">
					<?php echo $l->titlu_anunt; ?>
				</a>
			</div>
			<?php
			$data_add = explode(" ", $l->data_adaugarii);
			?>
			<div><?php echo JText::_('SAUTO_SHOW_DATE').' '.$data_add[0]; ?></div>
			<div><?php echo substr(strip_tags($l->anunt), 0, 50).' ...'; ?></div>
			<?php
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
	echo '<div style="position:relative;float:left;" class="sa_accesories"> :: '.$subacc.'</div>';
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
	echo '<div style="position:relative;float:left;" class="sa_accesories"> :: '.$model.'</div>';
	}
	echo '</div><div style="clear:both;"></div>';
}
			?>
		</td>
		<td valign="top" class="sa_table_cell">
			<?php	####################
			$query = "SELECT `fullname` FROM #__sa_profiles WHERE `uid` = '".$l->proprietar."'";
			$db->setQuery($query);
			$fullname = $db->loadResult();
			?>
			<table width="100%" class="sa_table_class">
			<?php 
			$link_calificativ = JRoute::_('index.php?option=com_sauto&view=calificativ');
			?>
			<?php /*<form action="<?php echo $link_calificativ; ?>" method="post" name="calificativ_<?php echo $l->id; ?>" id="calificativ_<?php echo $l->id; ?>">  */ ?>
				<tr class="sa_table_row">
					<td class="sa_table_cell">
					<?php
					$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
					?>
						<div class="sa_request_title">
							<a href="<?php echo $link_profile; ?>" class="sa_link_request">
								<?php echo $fullname; ?>
							</a>
						</div>
					</td>
				</tr>
				<tr class="sa_table_row">
					<td class="sa_table_cell">
					<?php
					$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
					$db->setQuery($query);
					$acordate = $db->loadResult();
				
					if ($acordate == 1) {
						//calificativ acordat
						$query = "SELECT `tip`, `mesaj` FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
						$db->setQuery($query);
						$calif = $db->loadObject();
						?>
						<div>
							<?php echo $calif->mesaj; ?>
						</div>
						<div style="display:inline;">
							<?php
							if ($calif->tip == 'p') { $calif_p = 'feedback_pozitiv.png'; } else { $calif_p = 'feedback_pozitiv_gri.png'; }
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_p; ?>" />
							</div>
							<?php
							if ($calif->tip == 'n') { $calif_n = 'feedback_neutru.png'; } else { $calif_n = 'feedback_neutru_gri.png'; 	}
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_n; ?>" />
							</div>
							<?php
							if ($calif->tip == 'x') { $calif_x = 'feedback_negativ.png'; } else { $calif_x = 'feedback_negativ_gri.png'; }
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_x; ?>" />
							</div>
						</div>
						<div style="clear:both;"></div>
						<?php
					} else {
						//neacordat
						?>
						<form action="<?php echo $link_calificativ; ?>" method="post" name="calificativ_<?php echo $l->id; ?>" id="calificativ_<?php echo $l->id; ?>">
						<div>
							<textarea name="calificativ_mess" cols="15" rows="1"></textarea>
						</div>
						<div>
							<?php
							$calif_p = 'feedback_pozitiv_gri.png';	
							$calif_n = 'feedback_neutru_gri.png';							
							$calif_x = 'feedback_negativ_gri.png';
							/*	echo '<input type="radio" name="calificativ_value" value="p" class="sa_feed_select sa_styled" />';
								echo '<input type="radio" name="calificativ_value" value="n" class="sa_feed_select sa_styled" />';
								echo '<input type="radio" name="calificativ_value" value="x" class="sa_feed_select sa_styled" />';
							*/ ?>
							<div id="calificativ_value" style="display:inline;">
								<div style="position:relative;float:left;margin-left:14px;">
								<label for="pozitiv_<?php echo $l->id; ?>">
									<input type="radio" name="calificativ_value" id="pozitiv_<?php echo $l->id; ?>" value="p" />
									<img src="<?php echo $img_path.$calif_p; ?>" alt="Pozitiv" />
								</label>
								</div>
								<div style="position:relative;float:left;margin-left:14px;">
								<label for="neutru_<?php echo $l->id; ?>">
									<input type="radio" name="calificativ_value" id="neutru_<?php echo $l->id; ?>" value="n" />
									<img src="<?php echo $img_path.$calif_n; ?>" alt="Neutru" />
								</label>
								</div>
								<div style="position:relative;float:left;margin-left:14px;">
								<label for="negativ_<?php echo $l->id; ?>">
									<input type="radio" name="calificativ_value" id="negativ_<?php echo $l->id; ?>" value="x" />
									<img src="<?php echo $img_path.$calif_x; ?>" alt="Negativ" />
								</label>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						<input type="hidden" name="poster_id" value="<?php echo $uid; ?>" />
						<input type="hidden" name="dest_id" value="<?php echo $l->proprietar; ?>" />
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
					</td>
					<?php

			?>
				</tr>
			</table> 

		</td>
	</tr>
	<?php
		if ($i == 5) {	
				$style = 'sa-row0'; 
				echo '<tr class="sa_table_row '.$style.'">';
					echo '<td class="sa_table_cell" colspan="3">';
						//echo $rec->cod_reclama;	
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
		<td class="sa_table_cell" valign="top" align="right">
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
<!---==========================MOBILE==========================================================================================================================================================================--->
<div id="m_table" style="width:100%!important;background-color:#F9F9F9">
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
	<!--=====================================MOBILLLLEE CONTENT======================================================-->
<div id="main-container" style="width:100%!important">
	<?php
	$i=1;
	foreach ($list as $l) {
	$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
	$image = 'anunt_type_'.$l->tip_anunt.'.png';
	?>
	<div id="pozaPret" style="width:40%;float:left;">
		<a href="<?php echo $link_categ; ?>" class="sa_lk_profile">
			<?php echo JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt); ?>
		</a>
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
		<div>
			<a href="<?php echo $link_categ; ?>" class="sa_lk_profile">
					<img src="<?php echo $poza; ?>" alt="<?php echo $alt; ?>" width="80" border="0" />
			</a>
		</div>
		<div>
			<?php //obtin pret + moneda
				$query = "SELECT `r`.`pret_oferit`, `m`.`m_scurt` FROM #__sa_raspunsuri as `r` JOIN #__sa_moneda as `m` ON `r`.`anunt_id` = '".$l->id."' AND `r`.`status_raspuns` = '1' AND `r`.`moneda` = `m`.`id`";
				$db->setQuery($query);
				$curency = $db->loadObject();
				echo JText::_('SAUTO_DISPLAY_PRICE').'<br />'.$curency->pret_oferit.' '.$curency->m_scurt;
			?>
			</div>
		</div>
	<div id="detaliiAnunt" style="width:60%;float:right;">
		<?php
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
		?>
		<div class="sa_request_title">
			<a href="<?php echo $link_anunt; ?>" class="sa_link_request">
				<?php echo $l->titlu_anunt; ?>
			</a>
		</div>
		<?php
			$data_add = explode(" ", $l->data_adaugarii);
		?>
		<div>
			<?php echo JText::_('SAUTO_SHOW_DATE').' '.$data_add[0]; ?>
		</div>
		<div>
			<?php echo substr(strip_tags($l->anunt), 0, 50).' ...'; ?>
		</div>
<?php
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
			echo '<div style="position:relative;float:left;" class="sa_accesories"> :: '.$subacc.'</div>';
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
			echo '<div style="position:relative;float:left;" class="sa_accesories"> :: '.$model.'</div>';
			}
			echo '</div><div style="clear:both;"></div>';
		}
?>
</div>
<div id="calificativInfo"style="width:70%;">
			<?php	####################
				$query = "SELECT `fullname` FROM #__sa_profiles WHERE `uid` = '".$l->proprietar."'";
				$db->setQuery($query);
				$fullname = $db->loadResult();
				$link_calificativ = JRoute::_('index.php?option=com_sauto&view=calificativ');
				$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			?>
			<div class="sa_request_title">
				<a href="<?php echo $link_profile; ?>" class="sa_link_request">
					<?php echo $fullname; ?>
				</a>
			</div>
			<?php
				$query = "SELECT count(*) FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
				$db->setQuery($query);
				$acordate = $db->loadResult();
				if ($acordate == 1) {
					//calificativ acordat
					$query = "SELECT `tip`, `mesaj` FROM #__sa_calificativ WHERE `poster_id` = '".$uid."' AND `anunt_id` = '".$l->id."'";
					$db->setQuery($query);
					$calif = $db->loadObject();
			?>
						<div>
							<?php echo $calif->mesaj; ?>
						</div>
						<div style="display:inline;">
							<?php
							if ($calif->tip == 'p') { $calif_p = 'feedback_pozitiv.png'; } else { $calif_p = 'feedback_pozitiv_gri.png'; }
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_p; ?>" />
							</div>
							<?php
							if ($calif->tip == 'n') { $calif_n = 'feedback_neutru.png'; } else { $calif_n = 'feedback_neutru_gri.png'; 	}
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_n; ?>" />
							</div>
							<?php
							if ($calif->tip == 'x') { $calif_x = 'feedback_negativ.png'; } else { $calif_x = 'feedback_negativ_gri.png'; }
							?>
							<div style="position:relative;float:left;margin-left:20px;">
								<img src="<?php echo $img_path.$calif_x; ?>" />
							</div>
						</div>
						<div style="clear:both;"></div>
						<?php
					} else {
						//neacordat
						?>
						<form action="<?php echo $link_calificativ; ?>" method="post" name="calificativ_<?php echo $l->id; ?>" id="calificativ_<?php echo $l->id; ?>">
						<div>
							<textarea name="calificativ_mess" cols="15" rows="1"></textarea>
						</div>
						<div>
							<?php
							$calif_p = 'feedback_pozitiv_gri.png';	
							$calif_n = 'feedback_neutru_gri.png';							
							$calif_x = 'feedback_negativ_gri.png';
							?>
							<div id="calificativ_value" style="display:inline;">
								<div style="position:relative;float:left;margin-left:14px;">
								<label for="pozitiv_<?php echo $l->id; ?>">
									<input type="radio" name="calificativ_value" id="pozitiv_<?php echo $l->id; ?>" value="p" />
									<img src="<?php echo $img_path.$calif_p; ?>" alt="Pozitiv" />
								</label>
								</div>
								<div style="position:relative;float:left;margin-left:14px;">
								<label for="neutru_<?php echo $l->id; ?>">
									<input type="radio" name="calificativ_value" id="neutru_<?php echo $l->id; ?>" value="n" />
									<img src="<?php echo $img_path.$calif_n; ?>" alt="Neutru" />
								</label>
								</div>
								<div style="position:relative;float:left;margin-left:14px;">
								<label for="negativ_<?php echo $l->id; ?>">
									<input type="radio" name="calificativ_value" id="negativ_<?php echo $l->id; ?>" value="x" />
									<img src="<?php echo $img_path.$calif_x; ?>" alt="Negativ" />
								</label>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
						<input type="hidden" name="poster_id" value="<?php echo $uid; ?>" />
						<input type="hidden" name="dest_id" value="<?php echo $l->proprietar; ?>" />
						<input type="hidden" name="id_anunt" value="<?php echo $l->id; ?>" />
						<input type="hidden" name="type" value="customer" />
						<input type="hidden" name="redirect" value="final" />
						
						</form>
						
						<div onClick="document.forms['calificativ_<?php echo $l->id; ?>'].submit();" class="sa_send_feedback sa_submit_feed">
							<?php echo JText::_('SAUTO_FEEDBACK_NOW_BUTTON'); ?>
						</div>
						<?php
					}
	}
					?>
<div id="filtre">
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
		?>
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
</div>
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
}
</script>