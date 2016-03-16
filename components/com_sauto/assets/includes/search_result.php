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
$db = JFactory::getDbo();
$page =& JRequest::getVar( 'page', '', 'get', 'string' );



//setam cookies
$app =& JFactory::getApplication();
if ($page == '') {
	
$request =& JRequest::getVar( 'request', '', 'post', 'string' );

$string_cautare =& JRequest::getVar( 'string_cautare', '', 'post', 'string' );
$search_in_1 =& JRequest::getVar( 'search_in_1', '', 'post', 'string' );
$search_in_2 =& JRequest::getVar( 'search_in_2', '', 'post', 'string' );
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$an_fabricatie =& JRequest::getVar( 'an_fabricatie', '', 'post', 'string' );
$cilindree =& JRequest::getVar( 'cilindree', '', 'post', 'string' );
$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );
$nr_usi =& JRequest::getVar( 'nr_usi', '', 'post', 'string' );
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$stare =& JRequest::getVar( 'stare', '', 'post', 'string' );
$tip_piesa =& JRequest::getVar('tip_piesa', '', 'post', 'string');
$judet =& JRequest::getVar('judet', '', 'post', 'string');
$city =& JRequest::getVar('localitate', '', 'post', 'string');
$buget_alocat =& JRequest::getVar('buget_alocat', '', 'post', 'string');
$buget_moneda =& JRequest::getVar('buget_moneda', '', 'post', 'string');
$judet_r =& JRequest::getVar('judet_r', '', 'post', 'string');
$city_r =& JRequest::getVar('localitate_r', '', 'post', 'string');
$acc =& JRequest::getVar('acc', '', 'post', 'string');
$subacc =& JRequest::getVar('subacc', '', 'post', 'string');
####
if ($marca != '') {
	$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
	$db->setQuery($query);
	$marca = $db->loadResult();
}
if ($judet != '') {
	$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
	$db->setQuery($query);
	$judet = $db->loadResult();
}
if ($judet_r != '') {
	$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet_r."'";
	$db->setQuery($query);
	$judet_r = $db->loadResult();
}
if ($acc != '') {
	$query = "SELECT `id` FROM #__sa_accesorii WHERE `accesorii` = '".$acc."'";
	$db->setQuery($query);
	$acc_id = $db->loadResult();
}
####
$app->setUserState('request', $request);
$app->setUserState('string_cautare', $string_cautare);
$app->setUserState('search_in_1', $search_in_1);
$app->setUserState('search_in_2', $search_in_2);
$app->setUserState('marca', $marca);
$app->setUserState('model_auto', $model_auto);
$app->setUserState('an_fabricatie', $an_fabricatie);
$app->setUserState('cilindree', $cilindree);
$app->setUserState('carburant', $carburant);
$app->setUserState('nr_usi', $nr_usi);
$app->setUserState('stare', $stare);
$app->setUserState('caroserie', $caroserie);
$app->setUserState('tip_piesa', $tip_piesa);
$app->setUserState('judet', $judet);
$app->setUserState('city', $city);
$app->setUserState('buget_alocat', $buget_alocat);
$app->setUserState('buget_moneda', $buget_moneda);
$app->setUserState('judet_r', $judet_r);
$app->setUserState('city_r', $city_r);
$app->setUserState('acc_id', $acc_id);
$app->setUserState('subacc', $subacc);
} else {

$request = $app->getUserState('request');
$string_cautare = $app->getUserState('string_cautare');
$search_in_1 = $app->getUserState('search_in_1');
$search_in_2 = $app->getUserState('search_in_2');
$marca = $app->getUserState('marca');
$model_auto = $app->getUserState('model_auto');
$an_fabricatie = $app->getUserState('an_fabricatie');
$cilindree = $app->getUserState('cilindree');
$carburant = $app->getUserState('carburant');
$nr_usi = $app->getUserState('nr_usi');
$stare = $app->getUserState('stare');
$caroserie = $app->getUserState('caroserie');
$tip_piesa = $app->getUserState('tip_piesa');	
$judet = $app->getUserState('judet');	
$city = $app->getUserState('city');
$buget_alocat = $app->getUserState('buget_alocat');
$buget_moneda = $app->getUserState('buget_moneda');
$acc_id = $app->getUserState('acc_id');
$subacc = $app->getUserState('subacc');
}



$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";


if ($search_in_1 == 1) {
	$s_title = "`titlu_anunt` LIKE '%".$string_cautare."%' AND ";
} else {
	$s_title = '';
}
if ($search_in_2 == 1) {
	$s_anunt = "`anunt` LIKE '%".$string_cautare."%' AND ";
} else {
	$s_anunt = '';
}

if ($marca != '') {	
	$s_marca = " `marca_auto` = '".$marca."' AND ";
} else {
	$s_marca = "";
}

if ($model_auto != '') {
	$s_model = " `model_auto` = '".$model_auto."' AND ";
} else {
	$s_model = "";
}

if ($acc_id != '') {
	$s_acc = " `accesorii_auto` = '".$acc_id."' AND ";
} else {
	$s_acc = "";
}
if ($subacc != '') {
	$s_subacc = " `subaccesorii_auto` = '".$subacc."' AND ";
} else {
	$s_subacc = "";
}

if ($tip_piesa == 1) {
	$s_tip_piesa = " `nou` = '1' AND ";
} elseif ($tip_piesa == 2) {
	$s_tip_piesa = " `sh` = '1' AND ";
} else {
	$s_tip_piesa = "";
}

if ($an_fabricatie != '') {
	$s_an_fabricatie = " `an_fabricatie` = '".$an_fabricatie."' AND ";
} else {
	$s_an_fabricatie = "";
}

if ($cilindree != '') {
	$s_cilindree = " `cilindree` = '".$cilindree."' AND ";
} else {
	$s_cilindree = "";
}

if ($carburant != '') {
	$s_carburant = " `carburant` = '".$carburant."' AND ";
} else {
	$s_carburant = "";
}

if ($nr_usi != '') {
	$s_nr_usi = " `nr_usi` = '".$nr_usi."' AND ";
} else {
	$s_nr_usi = "";
}

if ($caroserie != '') {
	$s_caroserie = " `caroserie` = '".$caroserie."' AND ";
} else {
	$s_caroserie = "";
}

if ($stare != '') {
	$s_stare = " `stare` = '".$stare."' AND ";
} else {
	$s_stare = "";
}

if ($judet != '') {
	$s_judet = " `judet` = '".$judet."' AND ";
} else {
	$s_judet = "";
}

if ($city != '') {
	$s_city = " `city` = '".$city."' AND ";
} else {
	$s_city = "";
}

if ($buget_alocat != '') {
	$s_buget = " `buget_max` > '".$buget_alocat."' AND `buget_moneda` = '".$buget_moneda."' AND ";
} else {
	$s_buget = "";
}

if ($judet_r != '') {
	$s_judet_r = " `judet_r` = '".$judet_r."' AND ";
} else {
	$s_judet_r = "";
}

if ($city_r != '') {
	$s_city_r = " `localitate_r` = '".$city_r."' AND ";
} else {
	$s_city_r = "";
}
###############
	$query = "SELECT count(*) FROM #__sa_anunturi WHERE ".$s_title." ".$s_anunt." ".$s_marca." ".$s_acc." ".$s_subacc." ".$s_tip_piesa." ".$s_model." ".$s_an_fabricatie." ".$s_cilindree." ".$s_carburant." ".$s_nr_usi." ".$s_caroserie." ".$s_stare." ".$s_judet." ".$s_city." ".$s_buget." ".$s_judet_r." ".$s_city_r." `status_anunt` = '1' AND `is_winner` = '0' AND `tip_anunt` = '".$request."'";
##############


$db->setQuery($query);
$total = $db->loadResult();
$width = 'style="width:800px;"';

if ($total == 0) {

	$link_return = JRoute::_('index.php?option=com_sauto&view=search_request'); 
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
		<?php echo JText::_('SA_MISSING_SEARCH_RESULTS_FORMS'); ?>
		<br />
		<a href="<?php echo $link_return; ?>"><?php echo JText::_('SA_RETURN_TO_SEARCH_FORMS'); ?></a>
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
	$rezult_pagina = '7';
//nr de pagini
$nr_pagini=ceil($total/$rezult_pagina); 

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

$link = JRoute::_('index.php?option=com_sauto&view=search_result');

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

############
$query = "SELECT * FROM #__sa_anunturi WHERE ".$s_title." ".$s_anunt." ".$s_marca." ".$s_acc." ".$s_subacc." ".$s_tip_piesa." ".$s_model."  ".$s_an_fabricatie." ".$s_cilindree." ".$s_carburant." ".$s_nr_usi." ".$s_caroserie." ".$s_stare." ".$s_judet." ".$s_city." ".$s_buget." ".$s_judet_r." ".$s_city_r." `status_anunt` = '1' AND `is_winner` = '0'  AND `tip_anunt` = '".$request."' ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
############

$db->setQuery($query);
$list = $db->loadObjectList();

$i=1;

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
	?>
<table class="sa_table_class">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
<table width="100%" class="sa_table_class">
	<?php
	foreach ($list as $l) {
		if ($style == ' sa-row1 ') { 
			$style = ' sa-row0 '; 
			} else { 
			$style = ' sa-row1 '; 
			}
		$image = 'anunt_type_'.$l->tip_anunt.'.png';
		$link_categ = JRoute::_('index.php?option=com_sauto&view=categories&id='.$l->tip_anunt);
		echo '<tr class="sa_table_row '.$style.'">';
			echo '<td width="15%" valign="top" class="sa_table_cell"><center>';
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
			$query = "SELECT `p`.`fullname`, `p`.`telefon`, `j`.`judet`, `p`.`abonament` FROM #__sa_profiles as `p` JOIN #__sa_judete as `j` ON `p`.`uid` = '".$l->proprietar."' AND `p`.`judet` = `j`.`id`";
			$db->setQuery($query);
			//echo $query;
			$userd = $db->loadObject();
			//print_r($userd);
			$link_profile = JRoute::_('index.php?option=com_sauto&view=public_profile&id='.$l->proprietar);
			echo '<div class="sa_request_title"><a href="'.$link_profile.'" class="sa_link_request">'.$userd->fullname.'</a></div>';
			echo '<div>'.JText::_('SAUTO_DISPLAY_JUDET').': '.$userd->judet.'</div>';
			
			echo '<div class="sa_table_cell sa_phone sa_phone_oferte">';
			echo '<img src="'.$img_path.'icon_phone.png" border="0" class="sa_phone_img" />';
			echo '<span class="sa_phone_span">';
				//afisam telefonul
				if ($view_phone == 0) {
					echo JText::_('SAUTO_TELEFON_ASCUNS');
				} else {
					echo $userd->telefon;
				}
								
			echo '</span>';
			echo '</div>';
			echo '<br />';
			echo '<div class="sa_table_cell sa_phone sa_phone_oferte sa_padding">';
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
			echo '</td>';
		echo '</tr>';
		//echo '<tr class="sa_table_row"><td colspan="3" height="10" class="sa_table_cell"><hr /></td></tr>';
	}
	?>
</table>

<br /><br />
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
			//echo '<div>'.$show_side_content.'</div>';	
		?>
		
			</div>
		</td>
	</tr>
</table>
