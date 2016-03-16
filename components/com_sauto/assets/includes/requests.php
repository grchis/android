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
require_once('/mobile/requests_mobile.php');
}else{
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
	//if ($uid == 0) { $link_filter = $link_this; }
	?>
<table class="sa_table_class m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_REQUESTS_DEALERS'); ?>
		<br />
		<a href="<?php echo $link_filter; ?>"><?php echo JText::_('SA_FILTRE_VEZI_TOATE_LINK'); ?></a>
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

$link = JRoute::_('index.php?option=com_sauto&view=requests');

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
        $paginare.='<a class="" ><span class="sa_page_current">'.$x.'</span></a>';
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

$query = "SELECT * FROM #__sa_anunturi WHERE `status_anunt` = '1' AND `is_winner` = '0'  ".$db_oferte." ".$db_piese." ".$db_judete." ".$db_marci." ".$db_orase." ".$db_modele." ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();

//echo '<table class="gym_table" width="100%">';
//echo '<tr class="gym_row"><td class="gym_adm_head_2">'.JText::_('GYM_NR_CRT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_USERNAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_NAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_EMAIL').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ABOMAMENT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ACTIONS').'</td></tr>';
//$i=1;
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

?>
<table class="sa_table_class m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>

<table class="sa_table_class m_table">
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
		<td class="sa_table_cell" valign="top"></td>
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
	if (($show_side_content != '') OR ($show_side_reclama != '')) {
	$width = 'style="width:800px;"';
	} else {
	$width = 'style="width:1000px;"';
	}

?>
<table class="sa_table_class">
	<?php
	$i=1;
	foreach ($list as $l) {
			if ($style == ' sa-row1 ') {
				$style = ' sa-row0 ';
			} else {
				$style = ' sa-row1 ';
			}
		//verific daca sunt castigatorul....
		$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$l->id."' AND `firma` = '".$uid."'";
		$db->setQuery($query);
		$check = $db->loadResult();

        $image = 'anunt_type_'.$l->tip_anunt.'.png';
        $link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
        echo '<tr class="sa_table_row '.$style.'">';
			echo '<td width="15%" valign="top" class="sa_table_cell"><center>';
			//echo '>> '.$check;
			echo '<div><a href="'.$link_categ.'" class="sa_lk_profile">'.JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt).'</a></div>';
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
			echo '<div><a href="'.$link_categ.'" class="sa_lk_profile"><img src="'.$poza.'" alt="'.$alt.'" width="80" border="0" /></a></div>';
				if ($check != 0) {
					//echo '<img src="'.$img_path.'check_yes.png" />';
					echo JHTML::_('tooltip',JText::_('SA_TOOLTIP_MESSAGE_OFERTA'), JText::_('SA_TOOLTIP_TITLE_OFERTA'), $img_path.'check_yes.png', '', '', false);
				}
			echo '</center></td>';
			echo '<td width="45%" valign="top" class="sa_table_cell">';
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=delete&id='.$l->id);
			echo '<div class="sa_request_title"><a href="'.$link_anunt.'" class="sa_link_request">'.$l->titlu_anunt.'</a></div>';
			$data_add = explode(" ",$l->data_adaugarii);
			echo '<div>'.JText::_('SAUTO_SHOW_DATE').' '.$data_add[0].'</div>';
			echo '<div>'.substr(strip_tags($l->anunt), 0, 50).' ...</div>';
			//substr(strip_tags($l->$def_desc), 0, 50)
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
			$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `p`.`abonament`, `p`.`deleted` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
			$db->setQuery($query);
			//echo $query;
			$userd = $db->loadObject();
			//print_r($userd);
			$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			echo '<div class="sa_request_title">';
				if ($userd->deleted == 0) {
					echo '<a href="'.$link_profile.'" class="sa_link_request">'.$userd->fullname.'</a>';
				} else {
					echo JText::_('SAUTO_CONT_INACTIV');
				}
			echo '</div>';
			echo '<div>'.JText::_('SAUTO_DISPLAY_JUDET').': '.$userd->judet.'</div>';

			echo '<div class="sa_table_cell sa_phone sa_phone_oferte sa_hover">';
			echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
			echo '<span class="sa_phone_span">';
				//afisam telefonul
			if ($userd->deleted == 0) {
				if ($view_phone == 0) {
					echo JText::_('SAUTO_TELEFON_ASCUNS');
				} else {
					echo $userd->telefon;
				}
			} else {
				echo JText::_('SAUTO_TELEFON_ASCUNS');
			}

			echo '</span>';
			echo '</div>';
			echo '<br />';
			echo '<a href="'.$link_anunt.'" class="sa_link_box"><div class="sa_table_cell sa_phone sa_phone_oferte sa_padding sa_hover">';
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
			echo '</div></a>';
			echo '</td>';
		echo '</tr>';


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
		//echo '<tr class="sa_table_row"><td colspan="3" height="10" class="sa_table_cell"><hr /></td></tr>';
	$i++;
	}
	?>
</table>

<br /><br />
<?php
if ($total > $rezult_pagina) {
	echo $paginare;
	if ($uid != 0) {
	$link_s_adv = JRoute::_('index.php?option=com_sauto&view=search_request');
	echo ' '.JText::_('SAUTO_OR').' <a href="'.$link_s_adv.'">'.JText::_('SAUTO_CAUTARE_AVANSATA').'</a>';
	}
}
echo '<br /><br />';

}
?>
</td>
		<td id="additional_td"class="sa_table_cell" valign="top" align="right">
			<div style="float:right;" class="sa_allrequest_r">
			<?php
			//incarcam module in functie de pagina accesata
			echo '<div class="sa_reclama_right">';
				$pozitionare = 'l';
				if ($ck_piese == 0) {
					$categ = '';
				} elseif ($ck_piese == '') {
					$categ = '';
				} else {
					$categ = $ck_piese;
				}
				echo showAds($pozitionare, $categ);
			echo '</div>';
			echo '<div>'.$show_side_content.'</div>';
		?>

			</div>
		</td>
	</tr>
</table>
<?php
}
?>