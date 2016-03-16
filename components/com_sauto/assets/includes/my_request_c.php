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
$user =& JFactory::getUser();
$uid = $user->id;
$img_path = JURI::base()."components/com_sauto/assets/images/";
$query = "SELECT count(*) FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `is_winner` = '0' AND `status_anunt` = '1'";
$db->setQuery($query);
$total = $db->loadResult();
$width = 'style="width:800px;"';
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(strpos($useragent,'Mobile')){
require_once('/mobile/my_request_c_mobile.php');
}else{
if ($total == 0) {
	//nu ai anunturi
	?>
<table class="sa_table_class" id="m_table">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
	<div class="sa_missing_request_1">
	<div class="sa_missing_request">
		<div class="sa_missing_request_left">
			<?php $link_add = JRoute::_('index.php?option=com_sauto&view=add_request'); ?>
			<img src="<?php echo $img_path; ?>icon_no_requests.png" border="0" />
		</div>
		<div class="sa_missing_request_right">
		<?php echo JText::_('SA_MISSING_REQUESTS').'<br /><a href="'.$link_add.'" class="sa_lk_profile">'.JText::_('SA_ADD_REQUEST_NOW').'</a>'; ?>
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
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//print_r($sconfig);
$total_rezult = $total;
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

$query = "SELECT * FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `status_anunt` = '1' AND `is_winner` = '0' ORDER BY `id` DESC LIMIT ".$inceput.", ".$rezult_pagina." ";
$db->setQuery($query);
$list = $db->loadObjectList();

//echo '<table class="gym_table" width="100%">';
//echo '<tr class="gym_row"><td class="gym_adm_head_2">'.JText::_('GYM_NR_CRT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_USERNAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_NAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_EMAIL').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ABOMAMENT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ACTIONS').'</td></tr>';
$i=1;
$image_path = JURI::base()."components/com_sauto/assets/users/";


?>
<table class="sa_table_class" id="m_table1">
	<tr class="sa_table_row">
		<td class="sa_table_cell" valign="top" <?php echo $width; ?>>
		
<table width="100%" class="sa_table_class">
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
			echo '<div><a href="'.$link_categ.'" class="sa_lk_profile">'.JText::_('SAUTO_TIP_ANUNT_DETAIL'.$l->tip_anunt).'</a></div>';
			//verificare poze
			$query = "SELECT `poza`,`alt` FROM #__sa_poze WHERE `id_anunt` = '".$l->id."' ORDER BY `id` ASC";
			$db->setQuery($query);
			$pics = $db->loadObject();
			if ($pics->poza != '') {
				$poza = $image_path.$uid."/".$pics->poza;
				$alt = $pics->alt;
			} else {
				$poza = $img_path.$image;
				$alt = '';
			}
			echo '<div><a href="'.$link_categ.'" class="sa_lk_profile"><img src="'.$poza.'" alt="'.$alt.'" width="80" border="0" /></a></div>';
			/*echo '<div>';
				if (($l->pret == '') or ($l->pret == 0)) {
					echo JText::_('SAUTO_PRET_NESPECIFICAT'); 
				} else {
					echo JText::_('SAUTO_DISPLAY_PRICE').'<br />'.$l->pret.' '.JText::_('SAUTO_CURENCY_RON');
				}
			echo '</div>';*/
			echo '</center></td>';
			echo '<td width="50%" valign="top" class="sa_table_cell">';
			$link_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$l->id);
			//$link_edit_anunt = JRoute::_('index.php?option=com_sauto&view=request_detail&task=edit&id='.$l->id);
			$link_delete_anunt = JRoute::_('index.php?option=com_sauto&view=delete&id='.$l->id);
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
			echo '<br /><br />';
			echo '<div style="display:inline;">';
			//obtin ofertele
			$query = "SELECT count(*) FROM #__sa_raspunsuri WHERE `anunt_id` = '".$l->id."'";
			$db->setQuery($query);
			$oferte = $db->loadResult();
				echo '<div style="position:relative;float:left;">';
					echo '<a href="'.$link_anunt.'" class="sa_link_box">';
					echo '<div class="sa_table_cell sa_phone sa_min_width sa_hover">';
						echo '<span class="sa_oferte_span">';
						//echo '<a href="'.$link_anunt.'">';
						if ($oferte == 1) {
							echo JText::_('SAUTO_O_OFERTA');
						} elseif ($oferte == 0) {
							echo JText::_('SAUTO_FARA_OFERTE');
						} else {
							echo $oferte.' '.JText::_('SAUTO_NR_OFERTE');
						}
						//echo '</a>';
					echo '</span>';
					echo '</div>';
					echo '</a>';
				echo '</div>';
				if ($oferte == 0) {
				echo '<div style="position:relative;float:right;">';
					$link_edit = JRoute::_('index.php?option=com_sauto&view=edit_request');
					echo '<form action="'.$link_edit.'" method="post" name="edit_form_'.$l->id.'" id="edit_form_'.$l->id.'">';
					echo '<input type="hidden" name="anunt_id" value="'.$l->id.'" />';
					echo '</form>';
					echo '<div class="sa_table_cell sa_phone sa_min_width sa_cursor sa_hover" onClick="document.forms[\'edit_form_'.$l->id.'\'].submit();">';
					echo '<span class="sa_oferte_span">';
						echo JText::_('SAUTO_EDIT_REQUEST');
					echo '</span>';
					echo '</div>';
				echo '</div>';
				}
			echo '</div><div style="clear:both;"></div>';
			echo '<br />';
			echo '<div style="display:inline;">';
			//obtin comentarii
			$query = "SELECT count(*) FROM #__sa_comentarii WHERE `anunt_id` = '".$l->id."'";
			$db->setQuery($query);
			$comms = $db->loadResult();
			echo '<div style="position:relative;float:left;">';
				$link_comments = JRoute::_('index.php?option=com_sauto&view=all_comment_list');
				echo '<form action="'.$link_comments.'" method="post" name="sa_list_comm_'.$l->id.'" id="sa_list_comm_'.$l->id.'">';
				echo '<input type="hidden" name="anunt_id" value="'.$l->id.'" />';
				//echo '<input type="submit" value="'.JText::_('SAUTO_COMMENTS_LIST').' ('.$total_comms.')" />'; 
				echo '</form>';
				if ($comms != 0) {
					echo '<div onClick="document.forms[\'sa_list_comm_'.$l->id.'\'].submit();" class="sa_table_cell sa_phone sa_min_width sa_cursor sa_hover">';
					echo '<span class="sa_oferte_span">';
				} else {
					echo '<div class="sa_table_cell sa_phone sa_min_width sa_inactive">';
					echo '<span class="sa_oferte_span sa_black">';
				}
				
				//echo JText::_('SAUTO_COMMENTS_LIST').' ('.$total_comms.')';
				echo $comms.' '.JText::_('SAUTO_COMMENTS');
				echo '</span>';
				echo '</div>';
			echo '</div>';

				if ($oferte == 0) {
				echo '<div style="position:relative;float:right;">';
				echo '<div class="sa_table_cell sa_phone sa_min_width sa_hover">';
				echo '<span class="sa_oferte_span">';
					echo '<a href="'.$link_delete_anunt.'" class="sa_delete_box">';
					echo JText::_('SAUTO_DELETE_REQUEST');
					echo '</a>';
				echo '</span>';
				echo '</div>';
				echo '</div>';
				}
			echo '</div><div style="clear:both;"></div>';
			echo '</td>';
		echo '</tr>';
		//echo '<tr class="sa_table_row '.$style.'"><td colspan="3" height="10" class="sa_table_cell"><hr class="sauto_hr" /></td></tr>';
	
	$i++;
	}
	?>
</table>
<?php
if ($total > $rezult_pagina) {
	echo '<div class="sa_paginare">'.$paginare.'</div>';
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




<div id="m_visitors" style="background-color:#F9F9F9">
<?php
$query = "SELECT * FROM #__sa_configurare WHERE `id` = '1'";
$db->setQuery($query);
$sconfig = $db->loadObject();
//print_r($sconfig);
$total_rezult1 = $total;
$rezult_pagina1 = 3;
//nr de pagini
$nr_pagini1=ceil($total_rezult1/$rezult_pagina1); 

$page1 =& JRequest::getVar( 'page', '', 'get', 'string' );
if(isset($page1) && is_numeric($page1)){
    $pagina_curenta1=(int)$page1;
} else {
    $pagina_curenta1=1;
}

if($pagina_curenta1 > $nr_pagini1) {
    $pagina_curenta1=$nr_pagini1;
} elseif($pagina_curenta1 < 1) {
    $pagina_curenta1=1;
}

$link1 = JRoute::_('index.php?option=com_sauto&view=my_request');

$interval1=3;
 
if($pagina_curenta1 > (1+$interval1)) {
	$paginare1.='<a class="sa_page" href="'.$link1.'&page=1">'.JText::_('SA_PRIMA_PAGINA').'</a>';
	$pagina_inapoi1=$pagina_curenta1-1;
    $paginare1.='<a class="sa_page" href="'.$link1.'&page='.$pagina_inapoi1.'">'.JText::_('SA_BACK_PAGE').'</a>';
} elseif (($pagina_curenta1 > 1) && ($pagina_curenta1 <= (1+$interval1))) {
    $pagina_inapoi1=$pagina_curenta1-1;
    $paginare1.='<a class="sa_page" href="'.$link1.'&page='.$pagina_inapoi1.'">'.JText::_('SA_BACK_PAGE').'</a>';
}

for($x1=($pagina_curenta1 - $interval1); $x1 < (($pagina_curenta1 + $interval1) + 1); $x1++) {
    if(($x1 > 0) && ($x1 <= $nr_pagini1)){  
      if($pagina_curenta1 != $x1){
        $paginare1.='<a class="sa_page" href="'.$link1.'&page='.$x1.'">'.$x1.'</a>';
      } else {
        $paginare1.='<a class="sa_page"><span class="sa_page_current">'.$x1.'</span></a>'; 
      }
    }
}


if(($pagina_curenta1 != $nr_pagini1) && ($pagina_curenta1 < ($nr_pagini1 - $interval1))){
    $pagina_inainte1=$pagina_curenta1+1;
    $paginare1.='<a  class="sa_page" href="'.$link1.'&page='.$pagina_inainte1.'">'.JText::_('SA_FORWARD_PAGE').'</a>';
    $paginare1.='<a  class="sa_page" href="'.$link1.'&page='.$nr_pagini1.'">'.JText::_('SA_LAST_PAGE').'</a>';
} elseif (($pagina_curenta1 != $nr_pagini1) && ($pagina_curenta1 >= ($nr_pagini1 - $interval1))){
    $pagina_inainte1=$pagina_curenta1+1;
    $paginare1.='<a class="sa_page" href="'.$link1.'&page='.$pagina_inainte1.'">'.JText::_('SA_FORWARD_PAGE').'</a>';
}


$inceput1=($pagina_curenta1 - 1) * $rezult_pagina1;

$query = "SELECT * FROM #__sa_anunturi WHERE `proprietar` = '".$uid."' AND `status_anunt` = '1' AND `is_winner` = '0' ORDER BY `id` DESC LIMIT ".$inceput1.", ".$rezult_pagina1." ";
$db->setQuery($query);
$list1 = $db->loadObjectList();

//echo '<table class="gym_table" width="100%">';
//echo '<tr class="gym_row"><td class="gym_adm_head_2">'.JText::_('GYM_NR_CRT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_USERNAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_NAME').'</td><td class="gym_adm_head_2">'.JText::_('GYM_EMAIL').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ABOMAMENT').'</td><td class="gym_adm_head_2">'.JText::_('GYM_ACTIONS').'</td></tr>';
$i=1;
?>


<?php
}
?>



